<?php
/*
 * Base.php - базовый (основной) класс
 */
namespace classes\BaseClass;

use \classes\Controller\Controller;
use \bcms\classes\Database\UserModel;
use \bcms\classes\Database\DatabaseModel;

/*
 * Базовый контроллер сайта
 */
abstract class Base extends Controller
{
    protected $title;  // заголовок страницы
    protected $content;  // содержание страницы
    protected $settings; // настройки cms
    private $pages; // массив страниц
    private $news; // подключение новости
    private $temp; // временная переменная
    protected $user; // текущий пользователь

    /*
     * Контроллер
     */
    function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /*
     * Виртуальный обработчик
     */
    protected function onInput()
    {
        // Основной заголовок страницы 
        $this->title = 'Новоозерновская основная общеобразовательная школа';
        // Содержание страницы
        $this->content = '';

        // Объявляем экземпляры классов для работы с базой данных
        $database = new DatabaseModel();

        $mUsers = UserModel::Instance();

        // Очистка старых сессий.
        $mUsers->ClearSessions();

        // Текущий пользователь.
        $this->user = $mUsers->Get();

        // Загружаем настройки cms из базы данных
        $this->settings = $database->selectSettings();

        $c = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($c == NULL) {
            header('Location: index.php?c=view&id=1');
        }

        $table = "page";

        // Загружаем все страницы из таблицы Page
        $this->pages = $database->select($table);

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (isset($id)) {
            $this->temp = $database->selectPageId($id);

            // Если на текущей странице news равен 1, то подключаем модуль "Новости"
            if ($this->temp['news'] == 1) {
                $this->news = 1;
            }
        }
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function OnOutput()
    {
        $vars = array(
            'title' => $this->title,
            'content' => $this->content,
            'user' => $this->user,
            'pages' => $this->pages,
            'news' => $this->news,
            'settings' => $this->settings,
            'temp' => $this->temp
        );
        $page = $this->Template('templates/' . $this->settings['template'] . '/v_main.php', $vars);
        echo $page;
    }
}