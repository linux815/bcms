<?php

namespace bcms\classes\Authorization;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\UserModel;

class Auth extends Base
{
    private ?int $error = null;

    protected function onInput(): void
    {
        parent::onInput();

        $this->title = 'Авторизация - ' . $this->title;

        $userModel = UserModel::Instance();

        // Очистка устаревших сессий
        $userModel->ClearSessions();

        // Получаем текущего пользователя
        $this->user = $userModel->Get() ?? [];

        // Если пользователь уже вошёл — выполняем выход
        if (!empty($this->user)) {
            $userModel->Logout();
            header('Location: index.php?c=auth');
            exit;
        }

        // Обработка отправки формы
        if ($this->isPost()) {
            $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = trim($_POST['password'] ?? '');
            $remember = isset($_POST['remember']);
            if ($userModel->Login($login, $password, $remember)) {
                header('Location: index.php');
                exit;
            }

            $this->error = 1;
        }
    }

    protected function onOutput(): void
    {
        $this->content = $this->template('templates/v_login.php', [
            'error' => $this->error,
        ]);

        parent::onOutput();
    }
}