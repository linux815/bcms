<?php
/*
 * Confirm.php — класс для подтверждения удаления
 */

namespace bcms\classes\Confirmation;

use bcms\classes\BaseClass\Base;

class Confirm extends Base
{
    private string $char = '';
    private ?string $delete = null;
    private ?int $id = null;

    protected function onInput(): void
    {
        parent::onInput();

        $this->title = 'Подтверждение - ' . $this->title;

        $this->delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$this->delete || !$this->id) {
            $this->redirectToHome();
        }

        $this->char = match ($this->delete) {
            'users' => "Вы действительно хотите удалить данного пользователя?",
            'page' => "Вы действительно хотите удалить данную страницу?",
            'news' => "Вы действительно хотите удалить данную новость?",
            default => $this->redirectToHome()
        };

        // Обработка подтверждения
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePost();
        }
    }

    private function redirectToHome(): void
    {
        $this->redirect('index.php');
    }

    private function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    private function handlePost(): void
    {
        if (isset($_POST['Yes'])) {
            $this->redirect("index.php?c=delete&delete={$this->delete}&id={$this->id}");
        }

        if (isset($_POST['No'])) {
            $target = match ($this->delete) {
                'users' => 'users',
                'page' => 'page',
                'news' => 'news',
                default => ''
            };
            $this->redirect("index.php?c={$target}");
        }
    }

    protected function onOutput(): void
    {
        $this->content = $this->template('templates/v_confirm.php', ['char' => $this->char]);
        parent::onOutput();
    }
}