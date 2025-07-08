<?php
/**
 * Module.php — подключение/отключение модулей
 */

namespace bcms\classes\Modules;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\DatabaseModel;

class Module extends Base
{
    protected string $nameSite = '';
    protected string $dbName = '';
    protected int $news = 0;
    protected int $ghost = 0;
    protected int $review = 0;

    protected function onInput(): void
    {
        parent::onInput();

        $this->title = 'Подключаемые модули - ' . $this->title;

        $db = new DatabaseModel();
        $settings = $db->selectSettings();

        $this->nameSite = $settings['namesite'] ?? '';
        $this->dbName = defined('DBNAME') ? DBNAME : '';
        $this->news = (int)($settings['news'] ?? 0);
        $this->ghost = (int)($settings['ghost'] ?? 0);
        $this->review = (int)($settings['review'] ?? 0);

        // Обработка переключения модулей
        $this->handleToggle($db);
    }

    private function handleToggle(DatabaseModel $db): void
    {
        $toggleFields = ['news', 'ghost', 'review'];

        foreach ($toggleFields as $field) {
            if (filter_has_var(INPUT_GET, $field)) {
                $this->$field = $this->$field === 1 ? 0 : 1;
                $db->updateSettings2($this->news, $this->ghost, $this->review);
                header('Location: index.php?c=modules');
                exit;
            }
        }
    }

    protected function onOutput(): void
    {
        $vars = [
            'nameSite' => $this->nameSite,
            'dbName' => $this->dbName,
            'news' => $this->news,
            'ghost' => $this->ghost,
            'review' => $this->review,
        ];

        $this->content = $this->template('templates/v_module.php', $vars);
        parent::onOutput();
    }
}