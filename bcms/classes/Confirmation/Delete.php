<?php
/*
 * Delete.php - удаление пользователей, страниц, новостей
 */

namespace bcms\classes\Confirmation;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\DatabaseModel;
use bcms\classes\Database\NewsModel;
use bcms\classes\Database\UserModel;

class Delete extends Base
{
    protected function onInput(): void
    {
        parent::onInput();

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Защита от удаления суперпользователя и главной страницы
        if (($delete === 'users' && $id === '1') || ($delete === 'page' && $id === '1')) {
            $this->redirectToSection($delete);
            return;
        }

        switch ($delete) {
            case 'users':
                UserModel::Instance()->deleteUser($id);
                $this->redirectToSection('users');
                break;

            case 'page':
                (new DatabaseModel())->deletePage($id);
                $this->redirectToSection('page');
                break;

            case 'news':
                (new NewsModel())->deleteNews($id);
                $this->redirectToSection('news');
                break;

            default:
                header('Location: index.php');
                exit;
        }
    }

    private function redirectToSection(string $section): void
    {
        header('Location: index.php?c=' . $section);
        exit;
    }

    protected function onOutput(): void
    {
        parent::onOutput();
    }
}