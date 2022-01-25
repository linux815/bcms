<?php

namespace Classes\ViewMain;

use bcms\classes\Database\DatabaseModel;
use Classes\BaseClass\Base;

class ViewMain extends Base
{
    protected ?string $nameSite = null;
    protected ?string $dbName = null;
    protected ?array $pageData = null;
    protected array $settings = [];

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        parent::__construct();
    }

    protected function onInput(): void
    {
        parent::onInput();

        $database = new DatabaseModel();

        $this->settings = $database->selectSettings();

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($id === null) {
            header('Location: index.php?c=view&id=1');
            exit;
        }

        $this->pageData = $database->selectPageId($id);
        $this->title = ($this->pageData['title'] ?? 'Без названия') . ' - Сайт школы';
    }

    protected function onOutput(): void
    {
        $vars = [
            'title' => $this->title,
            'nameSite' => $this->nameSite,
            'dbName' => $this->dbName,
            'content' => $this->pageData,
            'settings' => $this->settings,
        ];

        $this->content = $this->template(
            'templates/' . ($this->settings['template'] ?? 'default') . '/v_view.php',
            $vars,
        );
        parent::onOutput();
    }
}