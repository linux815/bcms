<?php
/*
 * Review.php - отзывы
 */
namespace classes\Modules;

use \bcms\classes\Database\ReviewModel;
use \bcms\classes\Database\DatabaseModel;
use \classes\BaseClass\BaseSecond;

/*
 * Контроллер страницы отзывов
 */
class Review extends BaseSecond
{

    public $error; // сообщение об ошибке

    /*
     * Виртуальный обработчик запроса
     */
    protected function onInput()
    {
        parent::onInput();

        // Объявляем экземпляры классов для работы с базой данных
        $database = new ReviewModel();
        $db = new DatabaseModel();

        // Задаем заголовок для страницы представления
        $this->title = 'Обратная связь - ' . $this->title;

        // Загружаем настройки cms из базы данных
        $settings = $db->selectSettings();

        if ($this->isPost()) {
            // Если ответили, что Вы не робот, то..
            if ($_POST['g-recaptcha-response'] != "") {
                $title = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $text = trim($_POST['text']);
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if ($settings['md_review'] == "admin") {
                    $database->addReview($title, $text, $name, $email);
                    $this->error = 2;
                } else {
                    mail($settings['email'], $title, $text);
                }
            } else {
                $this->error = 1;
            }
        }
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput()
    {
        $vars = array('error' => $this->error);
        $this->content = $this->template('templates/' . $this->settings['template'] . '/v_review.php', $vars);
        parent::onOutput();
    }
}