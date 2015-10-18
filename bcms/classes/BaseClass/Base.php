<?php 
/*
 * Base.php - базовый (основной) класс
 */
namespace bcms\classes\BaseClass;

use \bcms\classes\Controller\Controller;
use \bcms\classes\Database\UserModel;
use \bcms\classes\Database\DatabaseModel;

/*
 * Базовый контроллер сайта
 */
abstract class Base extends Controller
{
    protected $title; // заголовок страницы
    protected $content; // содержание страницы
    protected $settings; // настройки cms
    protected $user; // текущий пользователь
    protected $recycleCount; // общее количество удаленных элементов (страницы, пользователи, новости)

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
        $this->title = 'bCMS';
        // Содержание страницы 
        $this->content = '';

        // Объявляем экземпляры классов для работы с базой данных
        $database = new DatabaseModel();
        $mUsers = UserModel::Instance();

        // Очистка старых сессий.
        $mUsers->ClearSessions();

        // Текущий пользователь.
        $this->user = $mUsers->Get();

        if ($this->user[0] == "" and filter_input(INPUT_GET, 'c',
                    FILTER_SANITIZE_FULL_SPECIAL_CHARS) != 'auth') {
            header('Location: index.php?c=auth');
            die();
        }

        // Загружаем настройки cms из базы данных
        $this->settings = $database->selectSettings();

        // Считаем общее количество удаленных элементов (страницы, пользователи, новости)
        $page = $database->countDel("page");
        $news = $database->countDel("news");
        $users = $database->countDel("users");

        $this->recycleCount = $page[0] + $news[0] + $users[0];
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput()
    {
        $vars = array(
            'title' => $this->title, 
            'content' => $this->content, 
            'user' => $this->user, 
            'settings' => $this->settings, 
            'recyclecount' => $this->recycleCount
        );	
        $page = $this->template('templates/v_main.php', $vars);						
        echo $page;
    }	
}