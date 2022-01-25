<?php

declare(strict_types=1);

namespace bcms\classes\Search;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\DatabaseModel;

class FindPage extends Base
{
    protected array $allPage = [];

    protected function onInput(): void
    {
        parent::onInput();

        $this->title = 'Поиск - ' . $this->title;

        $field = trim((string)filter_input(INPUT_GET, 'field', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $text = trim((string)filter_input(INPUT_GET, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $table = trim((string)filter_input(INPUT_GET, 'find', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if ($field === '' || $text === '' || $table === '') {
            $this->allPage = []; // ничего не ищем, если параметры некорректны
            return;
        }

        $database = new DatabaseModel();
        $this->allPage = $database->findAll($field, $text, $table);
    }

    protected function onOutput(): void
    {
        $vars = ['allPage' => $this->allPage];

        $table = filter_input(INPUT_GET, 'find', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $template = match ($table) {
            'page' => 'templates/v_findPage.php',
            'users' => 'templates/v_findUsers.php',
            default => null
        };

        if ($template !== null) {
            $this->content = $this->template($template, $vars);
        }

        parent::onOutput();
    }
}