<?php

namespace Classes\BaseClass;

use App\Helpers\ViteAssets;
use bcms\classes\Database\DatabaseModel;
use bcms\classes\Database\UserModel;
use Classes\Controller\Controller;

/**
 * Вторичный базовый класс (используется для модулей)
 */
abstract class BaseSecond extends Controller
{
    protected string $title = '';
    protected string $content = '';
    protected array $settings = [];
    protected ?array $user;

    /**
     * Конструктор
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Виртуальный обработчик запроса
     */
    protected function onInput(): void
    {
        $database = new DatabaseModel();

        $this->title = 'bCMS';
        $this->content = '';

        $userModel = UserModel::Instance();

        // Очистка старых сессий
        $userModel->clearSessions();

        // Текущий пользователь
        $this->user = $userModel->get();

        // Загружаем настройки CMS
        $this->settings = $database->selectSettings();
    }

    /**
     * Виртуальный генератор HTML
     */
    protected function onOutput(): void
    {
        $viteAssets = new ViteAssets(
            __DIR__ . '/../../public/assets/manifest.json',
        );

        $vars = [
            'title' => $this->title,
            'content' => $this->content,
            'user' => $this->user,
            'settings' => $this->settings,
            'viteAssets' => $viteAssets,
        ];

        $templatePath = 'templates/' . ($this->settings['template'] ?? 'default') . '/v_mainSecond.php';
        $page = $this->template($templatePath, $vars);

        echo $page;
    }
}