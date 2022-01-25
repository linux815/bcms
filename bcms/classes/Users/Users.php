<?php
/**
 * Users.php — вывод пользователей
 * Устаревший модуль. Требует обновления.
 */

namespace bcms\classes\Users;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\UserModel;

class Users extends Base
{
    private int $page = 1;
    private int $perPage = 10;
    private array $pagination = [];
    private array $allUsers = [];

    protected function onInput(): void
    {
        parent::onInput();

        $this->title = 'Пользователи - ' . $this->title;

        $userModel = UserModel::Instance();
        $this->user = $userModel->Get() ?? [];

        if ($this->isPost()) {
            $this->handlePost($userModel);
        }

        $this->handleGet($userModel);
    }

    private function handlePost(UserModel $userModel): void
    {
        $del = filter_input(INPUT_POST, 'del');
        if ($del && isset($_POST['id_num']) && is_array($_POST['id_num'])) {
            foreach ($_POST['id_num'] as $userId) {
                $userModel->deleteUser((int)$userId[0]);
            }
        }

        $searchText = trim(filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
        $searchField = filter_input(INPUT_POST, 'field', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($searchText !== '') {
            header(
                "Location: index.php?c=find&find=users&field=" . urlencode($searchField) . "&text=" . urlencode(
                    $searchText,
                ),
            );
            exit;
        }
    }

    private function handleGet(UserModel $userModel): void
    {
        $delete = trim(filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
        if ($delete === 'ALL') {
            $userModel->deleteUserALL();
        }

        $this->page = max((int)($_GET['page'] ?? 1), 1);
        $totalUsers = $userModel->countUser();
        $totalPages = (int)ceil($totalUsers / $this->perPage);

        if ($this->page > $totalPages) {
            $this->page = $totalPages;
        }

        $offset = ($this->page - 1) * $this->perPage;
        $this->allUsers = $userModel->selectUser($offset, $this->perPage);

        $this->buildPagination($totalPages);
    }

    private function buildPagination(int $total): void
    {
        $this->pagination['first'] = $this->page > 1 ? 1 : null;
        $this->pagination['prev'] = $this->page > 1 ? $this->page - 1 : null;
        $this->pagination['next'] = $this->page < $total ? $this->page + 1 : null;
        $this->pagination['last'] = $this->page < $total ? $total : null;

        $this->pagination['pages'] = array_filter([
            $this->page - 2 > 0 ? $this->page - 2 : null,
            $this->page - 1 > 0 ? $this->page - 1 : null,
            $this->page,
            $this->page + 1 <= $total ? $this->page + 1 : null,
            $this->page + 2 <= $total ? $this->page + 2 : null,
        ]);
    }

    protected function onOutput(): void
    {
        $vars = [
            'user' => $this->user,
            'allUsers' => $this->allUsers,
            'pagination' => $this->pagination,
            'page' => $this->page,
        ];

        $this->content = $this->template('templates/v_users.php', $vars);
        parent::onOutput();
    }
}