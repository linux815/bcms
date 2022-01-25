<?php
/*
 * AddNews.php - добавление новости
 */

namespace bcms\classes\News;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\NewsModel;

class AddNews extends Base
{
    private ?string $error = null;

    //
    // Виртуальный обработчик запроса.
    //
    protected function onInput(): void
    {
        parent::onInput();

        $database = new NewsModel();

        $this->title = 'Добавление новости - ' . $this->title;

        if ($this->isPost()) {
            $title = trim((string)filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            if ($title === '') {
                $this->error = "Введите заголовок.";
            } else {
                $text = $_POST['content'] ?? '';
                $database->addNews($title, $text);
                header('Location: index.php?c=news');
                exit;
            }
        }
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function onOutput(): void
    {
        $vars = ['error' => $this->error];
        $this->content = $this->template('templates/v_addnews.php', $vars);
        parent::onOutput();
    }
}