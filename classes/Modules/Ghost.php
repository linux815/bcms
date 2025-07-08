<?php

namespace Classes\Modules;

use bcms\classes\Database\DatabaseModel;
use bcms\classes\Database\GhostModel;
use bcms\classes\Database\UserModel;
use Classes\BaseClass\BaseSecond;
use Random\RandomException;

class Ghost extends BaseSecond
{
    protected ?array $user;
    protected array $settings;
    private ?int $error = null;
    private array $ghost = [];

    /**
     * @throws RandomException
     */
    protected function onInput(): void
    {
        parent::onInput();

        $ghostDb = new GhostModel();
        $dbModel = new DatabaseModel();
        $userModel = UserModel::Instance();

        $userModel->ClearSessions();
        $this->user = $userModel->Get();
        $this->settings = $dbModel->selectSettings();

        $this->title = 'Гостевая книга - ' . $this->title;

        if ($this->isPost()) {
            // Проверяем математическую капчу
            $captchaUser = $_POST['captcha'] ?? '';
            $captchaAnswer = $_SESSION['captcha_answer'] ?? null;

            if ($captchaAnswer !== null && trim($captchaUser) === (string)$captchaAnswer) {
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $text = trim($_POST['text'] ?? '');
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $ghostDb->addMessage($name, $email, $url, $text);
                $this->error = 2; // успех

                // Обновим капчу
                unset($_SESSION['captcha_answer']);
            } else {
                $this->error = 1; // ошибка капчи
            }
        }

        $this->ghost = $ghostDb->selectGhost();

        // Удаление сообщения (админ)
        $deleteId = filter_input(INPUT_GET, 'ghost', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($deleteId !== null) {
            $ghostDb->deleteGhost($deleteId);
            header('Location: index.php?c=view&id=30');
            exit;
        }

        // Генерируем новую капчу (сложение)
        $a = random_int(1, 9);
        $b = random_int(1, 9);
        $_SESSION['captcha_question'] = "Сколько будет $a + $b ?";
        $_SESSION['captcha_answer'] = $a + $b;
    }

    protected function onOutput(): void
    {
        $vars = [
            'user' => $this->user,
            'error' => $this->error,
            'ghost' => $this->ghost,
            'settings' => $this->settings,
            'captcha_question' => $_SESSION['captcha_question'] ?? '',
        ];
        $this->content = $this->template(
            'templates/' . $this->settings['template'] . '/v_ghost.php',
            $vars,
        );

        parent::onOutput();
    }
}