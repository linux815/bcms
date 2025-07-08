<?php
/**
 * ViewUser.php — просмотр одного пользователя
 */

namespace bcms\classes\Users;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\UserModel;

class ViewUser extends Base
{
    protected array $user = [];
    private ?array $userData = null;
    private ?array $sessionData = null;

    protected function onInput(): void
    {
        parent::onInput();

        $this->title = 'Информация о пользователе - ' . $this->title;

        $userModel = UserModel::Instance();

        $this->user = $userModel->Get() ?? [];

        $userId = (int)(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? 0);
        if ($userId <= 0) {
            header('Location: index.php?c=users');
            exit;
        }

        $this->userData = $userModel->selectUserID($userId);
        $this->sessionData = $userModel->selectUserSession($userId);

        // Обработка POST-запросов на действия
        if ($this->isPost()) {
            $this->handlePost($userId);
        }
    }

    private function handlePost(int $userId): void
    {
        if (isset($_POST['Close'])) {
            header('Location: index.php?c=users');
            exit;
        }

        if (isset($_POST['Edit'])) {
            header("Location: index.php?c=edituser&id={$userId}");
            exit;
        }

        if (isset($_POST['delete'])) {
            header("Location: index.php?c=confirm&delete=users&id={$userId}");
            exit;
        }

        if (isset($_POST['Block'])) {
            echo "<script>alert('Можете дописать данный функционал, если вам требуется.')</script>";
        }
    }

    protected function onOutput(): void
    {
        $vars = [
            'user' => $this->user,
            'userID' => $this->userData,
            'session' => $this->sessionData,
        ];

        $this->content = $this->template('templates/v_viewUser.php', $vars);
        parent::onOutput();
    }
}