<?php
/**
 * Recycle.php — модуль корзины (устаревший, требует полной переработки)
 */

namespace bcms\classes\Modules;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\DatabaseModel;
use bcms\classes\Database\UserModel;

class Recycle extends Base
{
    private string $page = '1';
    private string $table = 'page';
    private string $tableId = 'id_page';

    private array $recycle = [];
    private array $pagination = [];

    private int $perPage = 10;
    private int $totalPages = 1;
    private int $totalItems = 0;

    private array $templateMap = [
        'page' => 'templates/v_recyclePage.php',
        'users' => 'templates/v_recycleUser.php',
        'news' => 'templates/v_recycleNews.php',
    ];

    protected function onInput(): void
    {
        parent::onInput();
        $this->title = 'Корзина - ' . $this->title;

        $db = new DatabaseModel();
        $users = UserModel::Instance();
        $users->ClearSessions();
        $this->user = $users->Get();

        $this->resolveDeletionTarget();
        $this->handleActions($db);

        $this->preparePagination($db);
        $this->recycle = $db->selectDel($this->table, $this->getStartIndex(), $this->perPage);
    }

    private function resolveDeletionTarget(): void
    {
        $delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'page';
        $this->table = $delete;

        $map = [
            'page' => 'id_page',
            'users' => 'id_user',
            'news' => 'id_news',
        ];

        $this->tableId = $map[$this->table] ?? 'id_page';
        $this->page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '1';
        $delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        switch ($delete) {
            case 'users':
                $this->table = 'users';
                $this->tableId = 'id_user';
                break;
            case 'page':
                $this->table = 'page';
                $this->tableId = 'id_page';
                break;
            case 'news':
                $this->table = 'news';
                $this->tableId = 'id_news';
                break;
            default:
        }
    }

    private function handleActions(DatabaseModel $db): void
    {
        // Обработка переключения из формы
        foreach (['users', 'page', 'news'] as $target) {
            if (filter_has_var(INPUT_POST, $target)) {
                header("Location: index.php?c=recycle&delete={$target}");
                exit;
            }
        }

        // Восстановление / удаление по ID
        $id = filter_input(INPUT_GET, 'id_rec', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $noRestore = filter_has_var(INPUT_GET, 'no_restore');

        if ($id) {
            if ($noRestore) {
                $db->deleteRecycleID($id, $this->table, $this->tableId);
            } else {
                $db->recoveryRecycleID($id, $this->table, $this->tableId);
            }
            header("Location: index.php?c=recycle&delete={$this->table}");
            exit;
        }

        // Массовое восстановление
        if (filter_has_var(INPUT_POST, 'del') && is_array($_POST['id_num'] ?? null)) {
            foreach ($_POST['id_num'] as $num) {
                if (is_array($num)) {
                    $db->recoveryRecycleID($num[0], $this->table, $this->tableId);
                } else {
                    $db->recoveryRecycleID($num, $this->table, $this->tableId);
                }
            }
        }
    }

    private function preparePagination(DatabaseModel $db): void
    {
        $countResult = $db->countDel($this->table);
        $this->totalItems = max(1, (int)($countResult[0] ?? 10));
        $this->perPage = min($this->totalItems, 10);
        $this->totalPages = (int)ceil($this->totalItems / $this->perPage);

        $currentPage = max(1, min((int)$this->page, $this->totalPages));
        $this->page = (string)$currentPage;

        $this->pagination = [
            'current' => $currentPage,
            'first' => $currentPage > 1 ? 1 : null,
            'prev' => $currentPage > 1 ? $currentPage - 1 : null,
            'next' => $currentPage < $this->totalPages ? $currentPage + 1 : null,
            'last' => $currentPage < $this->totalPages ? $this->totalPages : null,
            'pages' => array_filter([
                $currentPage - 2 > 0 ? $currentPage - 2 : null,
                $currentPage - 1 > 0 ? $currentPage - 1 : null,
                $currentPage,
                $currentPage + 1 <= $this->totalPages ? $currentPage + 1 : null,
                $currentPage + 2 <= $this->totalPages ? $currentPage + 2 : null,
            ]),
        ];
    }

    private function getStartIndex(): int
    {
        return ((int)$this->page - 1) * $this->perPage;
    }

    protected function onOutput(): void
    {
        $vars = [
            'user' => $this->user,
            'recycle' => $this->recycle,
            'num' => $this->perPage,
            'pagination' => $this->pagination,
            'page' => $this->page,
        ];

        $template = $this->templateMap[$this->table] ?? 'templates/v_recyclePage.php';
        $this->content = $this->template($template, $vars);

        parent::onOutput();
    }
}