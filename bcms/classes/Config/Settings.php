<?php

declare(strict_types=1);

namespace bcms\classes\Config;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\DatabaseModel;

class Settings extends Base
{
    private DatabaseModel $database;

    private string $nameSite = '';
    private string $template = '';
    private string $dbName = ''; // Пока не инициализирована — можно загрузить из конфига или убрать из шаблона
    private string $version = '4.0.1';
    private int $news = 0;
    private int $review = 0;
    private int $mUsers = 0;
    private string $mdReview = '';
    private string $keywords = '';
    private string $description = '';
    private int $ghost = 0;

    // Флаг успешного сохранения (показываем уведомление в шаблоне)
    private bool $success = false;

    public function __construct()
    {
        parent::__construct();
        $this->database = new DatabaseModel();
    }

    protected function onInput(): void
    {
        parent::onInput();

        // Заголовок страницы
        $this->title = 'Настройки - ' . $this->title;

        // Загружаем настройки из базы
        $settings = $this->database->selectSettings();

        $this->populateProperties($settings);

        if ($this->isPost()) {
            $this->handlePost();
        }
    }

    /**
     * @param array<string, mixed> $settings
     * @return void
     */
    private function populateProperties(array $settings): void
    {
        $this->nameSite = $settings['namesite'] ?? '';
        $this->news = (int)($settings['news'] ?? 0);
        $this->ghost = (int)($settings['ghost'] ?? 0);
        $this->review = (int)($settings['review'] ?? 0);
        $this->mUsers = (int)($settings['m_users'] ?? 0);
        $this->mdReview = $settings['md_review'] ?? '';
        $this->template = $settings['template'] ?? '';
        $this->keywords = $settings['keywords'] ?? '';
        $this->description = $settings['description'] ?? '';
    }

    private function handlePost(): void
    {
        $menu = filter_input(INPUT_POST, 'menu', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
        $mUsersFlag = ($menu === 'users') ? 1 : 0;

        $this->mdReview = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
        $template = filter_input(INPUT_POST, 'template', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
        $nameSite = filter_input(INPUT_POST, 'namesite', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
        $keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';

        $this->database->updateSettings(
            $template,
            $nameSite,
            $mUsersFlag,
            $this->mdReview,
            $keywords,
            $description,
        );

        // Обновляем свойства, чтобы новые данные сразу отобразились в шаблоне
        $this->populateProperties([
            'namesite' => $nameSite,
            'template' => $template,
            'm_users' => $mUsersFlag,
            'md_review' => $this->mdReview,
            'keywords' => $keywords,
            'description' => $description,
            // Остальные значения не меняются при обновлении
            'news' => $this->news,
            'ghost' => $this->ghost,
            'review' => $this->review,
        ]);

        $this->success = true;

        // Можно раскомментировать, если нужен редирект после сохранения
        // header('Location: index.php?c=settings&success=1');
        // exit;
    }

    protected function onOutput(): void
    {
        $vars = [
            'nameSite' => $this->nameSite,
            'dbName' => $this->dbName,
            'version' => $this->version,
            'news' => $this->news,
            'review' => $this->review,
            'm_users' => $this->mUsers,
            'md_review' => $this->mdReview,
            'template' => $this->template,
            'keywords' => $this->keywords,
            'description' => $this->description,
            'success' => $this->success,
        ];

        $this->content = $this->template('templates/v_settings.php', $vars);
        parent::onOutput();
    }
}