<?php
/*
 * AddPage.php — добавление новой страницы
 */

namespace bcms\classes\Page;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\DatabaseModel;

class AddPage extends Base
{
    private ?string $error = null;

    protected function onInput(): void
    {
        parent::onInput();

        $this->title = 'Создание новой страницы - ' . $this->title;

        if (!$this->isPost()) {
            return;
        }

        $title = trim((string)filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $hide = (int)filter_input(INPUT_POST, 'hide', FILTER_VALIDATE_INT);

        if ($title === '') {
            $this->error = 'Введите название страницы.';
            return;
        }

        $database = new DatabaseModel();
        $database->addPage($title, $hide);

        header('Location: index.php?c=page');
        exit;
    }

    protected function onOutput(): void
    {
        $this->content = $this->template('templates/v_addpage.php', [
            'error' => $this->error,
        ]);

        parent::onOutput();
    }
}