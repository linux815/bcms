<?php

namespace Classes\BaseClass;

use App\Helpers\ViteAssets;
use bcms\classes\Database\DatabaseModel;
use bcms\classes\Database\UserModel;
use Classes\Controller\Controller;

/**
 * Базовый контроллер сайта
 */
abstract class Base extends Controller
{
    protected string $title = '';
    protected string $content = '';
    protected array $settings = [];
    protected ?array $user = null;
    private ?array $pages = null;
    private ?int $news = null;
    private ?array $temp = null;

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
        $this->title = 'Сайт школы';
        $this->content = '';

        $database = new DatabaseModel();
        $userModel = UserModel::Instance();

        // Очистка старых сессий
        $userModel->clearSessions();

        // Получаем текущего пользователя
        $this->user = $userModel->get();

        // Загружаем настройки CMS
        $this->settings = $database->selectSettings();

        $controller = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($controller === null) {
            header('Location: index.php?c=view&id=1');
            exit;
        }

        $table = 'page';

        // Загружаем все страницы
        $this->pages = $database->select($table);

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($id !== null) {
            $this->temp = $database->selectPageId($id);

            if (!empty($this->temp['news']) && $this->temp['news'] === 1) {
                $this->news = 1;
            }
        }
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
            'pages' => $this->pages,
            'news' => $this->news,
            'settings' => $this->settings,
            'temp' => $this->temp,
            'viteAssets' => $viteAssets,
        ];

        $templatePath = 'templates/' . ($this->settings['template'] ?? 'default') . '/v_main.php';
        $page = $this->template($templatePath, $vars);

        echo $page;
    }
}