<?php

namespace bcms\classes\BaseClass;

use App\Helpers\ViteAssets;
use bcms\classes\Controller\Controller;
use bcms\classes\Database\UserModel;

abstract class BaseSecond extends Controller
{
    protected string $title = 'bCMS';
    protected string $content = '';
    protected array $user = [];

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function onInput(): void
    {
        $userModel = UserModel::Instance();

        // Очистка устаревших сессий
        $userModel->ClearSessions();

        // Получение текущего пользователя
        $this->user = $userModel->Get() ?? [];
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
            'viteAssets' => $viteAssets,
        ];

        echo $this->template('templates/v_mainSecond.php', $vars);
    }
}