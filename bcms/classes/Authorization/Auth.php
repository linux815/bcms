<?php
/*
 * Auth.php - авторизация
 */
namespace bcms\classes\Authorization;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\UserModel;

/*
 * Контроллер страницы авторизации
 */
class Auth extends Base
{
    private $error; // сообщение об ошибке

    /*
     * Виртуальный обработчик запроса
     */
    protected function onInput()
    {
        parent::onInput();

        // Задаем заголовок для страницы представления
        $this->title = 'Авторизация - ' . $this->title;

        // Менеджеры.
        $mUsers = UserModel::Instance();
        
        // Очистка старых сессий.
        $mUsers->ClearSessions();
        
        // Текущий пользователь.
        $this->user = $mUsers->Get();

        if ($this->user[0] != "") {
            // Выход.
            $mUsers->Logout();
            header('Location: index.php?c=auth');
            die();
        }

        // Выход.
        $mUsers->Logout();
        
        // Обработка отправки формы.
        if (parent::isPost()) { 
            if ($mUsers->Login(
                    filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS), 
                    trim($_POST['password']), 
                    isset($_POST['remember'])
            )) {
                header('Location: index.php');
                die();
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
        $this->content = $this->template('templates/v_login.php', $vars);
        parent::onOutput();
    }
}