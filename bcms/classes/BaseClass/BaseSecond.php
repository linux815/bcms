<?php 
/*
 * BaseSecond.php - вторичный (основной) класс с пустым шаблоном (используется для модулей в основном)
 */
namespace bcms\classes\BaseClass;

use \bcms\classes\Controller\Controller;
use \bcms\classes\Database\UserModel;

/*
 * Базовый контроллер сайта в котором содержится пустой шаблон
 */
abstract class BaseSecond extends Controller
{
    protected $title; // заголовок страницы
    protected $content; // содержание страницы

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
        $this->title = 'bCMS';
        $this->content = '';

        // Объявляем экземпляры классов для работы с базой данных
        $mUsers = UserModel::Instance();

        // Очистка старых сессий.
        $mUsers->ClearSessions();

        // Текущий пользователь.
        $this->user = $mUsers->Get();
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput()
    {
        $vars = array(
            'title' => $this->title, 
            'content' => $this->content, 
            'user' => $this->user
        );	
        $page = $this->template('templates/v_mainSecond.php', $vars);				
        echo $page;
    }	
}