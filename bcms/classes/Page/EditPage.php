<?php
/*
 * EditPage.php — редактирование страницы
 */

namespace bcms\classes\Page;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\DatabaseModel;

class EditPage extends Base
{
    private ?string $error = null;
    private ?array $page = null;

    protected function onInput(): void
    {
        parent::onInput();

        $this->title = 'Редактирование страницы - ' . $this->title;
        $database = new DatabaseModel();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: index.php?c=page');
            exit;
        }

        $this->page = $database->selectPageId($id);
        if (!$this->page) {
            $this->error = 'Страница не найдена.';
            return;
        }

        if (!$this->isPost()) {
            return;
        }

        $title = trim((string)filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $text = $_POST['content'] ?? '';
        $html = 0;

        if ($title === '') {
            $this->error = 'Введите название страницы.';
            return;
        }

        $database->pageUpdate($id, $title, $text, $html);
        header('Location: index.php?c=page');
        exit;
    }

    protected function onOutput(): void
    {
        $this->content = $this->template('templates/v_editpage.php', [
            'error' => $this->error,
            'page' => $this->page,
        ]);

        parent::onOutput();
    }
}