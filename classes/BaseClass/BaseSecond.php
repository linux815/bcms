<?php
/*
 * BaseSecond.php - вторичный базовый класс (используется в основном для модулей)
 */
namespace classes\BaseClass;

use \classes\Controller\Controller;
use \bcms\classes\Database\UserModel;
use \bcms\classes\Database\DatabaseModel;

/*
 * Базовый контроллер сайта
 */
abstract class BaseSecond extends Controller
{

    protected $title; // заголовок страницы
    protected $content; // содержание страницы
    protected $settings; // настройки cms
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
        // Объявляем экземпляры классов для работы с базой данных
        $database = new DatabaseModel();

        // Основной заголовок страницы
        $this->title = 'MaxiCMS';
        // Содержание страницы
        $this->content = '';

        $mUsers = UserModel::Instance();

        // Очистка старых сессий.
        $mUsers->ClearSessions();

        // Текущий пользователь.
        $this->user = $mUsers->Get();

        // Загружаем настройки cms из базы данных
        $this->settings = $database->selectSettings();
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
            'settings' => $this->settings
        );
        $page = $this->template('templates/' . $this->settings['template'] . '/v_mainSecond.php', $vars);
        echo $page;
    }
}