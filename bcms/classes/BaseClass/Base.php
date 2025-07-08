<?php

namespace bcms\classes\BaseClass;

use App\Helpers\ViteAssets;
use bcms\classes\Controller\Controller;
use bcms\classes\Database\DatabaseModel;
use bcms\classes\Database\UserModel;

abstract class Base extends Controller
{
    protected string $title = 'bCMS';
    protected string $content = '';
    protected array $settings = [];
    protected array $user = [];
    protected int $recycleCount = 0;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function onInput(): void
    {
        $this->title = 'bCMS';
        $this->content = '';

        $database = new DatabaseModel();
        $mUsers = UserModel::Instance();

        $mUsers->ClearSessions();

        $this->user = $mUsers->Get() ?? [];

        if (empty($this->user) && filter_input(INPUT_GET, 'c', FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== 'auth') {
            header('Location: index.php?c=auth');
            exit;
        }

        $this->settings = $database->selectSettings();

        $pageCount = $database->countDel('page')['count'] ?? 0;
        $newsCount = $database->countDel('news')['count'] ?? 0;
        $usersCount = $database->countDel('users')['count'] ?? 0;

        $this->recycleCount = $pageCount + $newsCount + $usersCount;
    }

    protected function onOutput(): void
    {
        $viteAssets = new ViteAssets(
            __DIR__ . '/../../../public/assets/manifest.json',
        );

        $vars = [
            'title' => $this->title,
            'content' => $this->content,
            'user' => $this->user,
            'settings' => $this->settings,
            'recyclecount' => $this->recycleCount,
            'viteAssets' => $viteAssets,
        ];

        echo $this->template('templates/v_main.php', $vars);
    }
}