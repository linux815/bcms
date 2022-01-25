<?php
/*
 * EditNews.php — редактирование новости
 */

namespace bcms\classes\News;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\NewsModel;

class EditNews extends Base
{
    private ?string $error = null;
    private array $news = [];

    protected function onInput(): void
    {
        parent::onInput();

        $database = new NewsModel();
        $this->title = 'Редактирование новости - ' . $this->title;

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: index.php?c=news');
            exit;
        }

        $newsData = $database->selectNewsId($id);

        if (!is_array($newsData) || empty($newsData)) {
            $this->error = "Новость не найдена.";
            return;
        }

        $this->news = $newsData;

        if ($this->isPost()) {
            $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $text = $_POST['content'] ?? '';

            if (empty($title)) {
                $this->error = "Введите заголовок.";
                return;
            }

            $database->newsUpdate($id, $title, $text);
            header('Location: index.php?c=news');
            exit;
        }
    }

    protected function onOutput(): void
    {
        $vars = [
            'error' => $this->error,
            'news' => $this->news,
        ];

        $this->content = $this->template('templates/v_editnews.php', $vars);
        parent::onOutput();
    }
}