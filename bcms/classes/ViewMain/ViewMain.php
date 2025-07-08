<?php

namespace bcms\classes\ViewMain;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\DatabaseModel;

class ViewMain extends Base
{
    protected string $nameSite = '';
    protected string $dbName = '';
    protected array $vars = [];

    protected function onInput(): void
    {
        parent::onInput();

        $database = new DatabaseModel();

        $this->title = 'Главная - ' . $this->title;

        $settings = $database->selectSettings();

        $this->nameSite = $settings['namesite'] ?? '';
        $this->dbName = defined('DBNAME') ? DBNAME : '';

        // Получаем статистику для блока "Общая информация"
        $userCount = $database->countUsers()['count'] ?? 0;
        $pageCount = $database->countPage()['count'] ?? 0;
        $newsCount = $database->countNews()['count'] ?? 0;
        $guestbookCount = $database->countGhost();
        $reviewCount = $database->countReviews();

        $recycleCount = $this->recycleCount;

        $this->vars = [
            'settings' => $settings,
            'userCount' => $userCount,
            'pageCount' => $pageCount,
            'newsCount' => $newsCount,
            'guestbookCount' => $guestbookCount,
            'reviewCount' => $reviewCount,
            'recycleCount' => $recycleCount,
        ];
    }

    protected function onOutput(): void
    {
        $vars = array_merge(
            [
                'nameSite' => $this->nameSite,
                'dbName' => $this->dbName,
            ],
            $this->vars,
        );

        $this->content = $this->template('templates/v_view.php', $vars);

        parent::onOutput();
    }
}