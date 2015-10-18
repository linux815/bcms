<?php
/*
 * Ghost.php - модуль гостевая книга
 */
namespace classes\Modules;

use \bcms\classes\Database\GhostModel;
use \bcms\classes\Database\UserModel;
use \bcms\classes\Database\DatabaseModel;
use \classes\BaseClass\BaseSecond;

/*
 * Контроллер страницы чтения
 */
class Ghost extends BaseSecond
{

    public $user; // Пользователи
    private $error; // сообщение об ошибке
    private $ghost; // массив таблицы ghost
    protected $settings; // настройки cms

    /*
     * Виртуальный обработчик запроса
     */
    protected function onInput()
    {
        parent::onInput();

        // Объявляем экземпляры классов для работы с базой данных
        $database = new GhostModel();
        $databaseModel = new DatabaseModel();
        $mUsers = UserModel::Instance();

        // Очистка старых сессий.
        $mUsers->ClearSessions();

        // Текущий пользователь.
        $this->user = $mUsers->Get();

        // Загружаем настройки cms из базы данных
        $this->settings = $databaseModel->selectSettings();

        // Основной заголовок страницы
        $this->title = 'Гостевая книга - ' . $this->title;

        // echo "<pre>"; echo print_r($_REQUEST); echo "</pre>";

        if ($this->isPost()) {
            // Если ответили, что Вы не робот, то..
            if ($_POST['g-recaptcha-response'] != "") {
                $title = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $text = trim($_POST['text']);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $database->addMessage($title, $email, $url, $text);
                $this->ghost = $database->selectGhost();
                $this->error = 2;
            } else {
                $this->error = 1;
            }
        }

        $this->ghost = $database->selectGhost();

        $ghost = filter_input(INPUT_GET, 'ghost', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (isset($ghost)) {
            $database->deleteGhost($ghost);
            header('Location: index.php?c=view&id=30');
            die();
        }
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput()
    {
        $vars = array(
            'user' => $this->user,
            'error' => $this->error,
            'ghost' => $this->ghost,
            'settings' => $this->settings
        );
        $this->content = $this->template('templates/' . $this->settings['template'] . '/v_ghost.php', $vars);
        parent::onOutput();
    }

}