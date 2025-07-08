<?php
/*
 * Page.php - вывод страниц
 * ========================
 * Устаревший модуль. Необходимо обновить!
 */

namespace bcms\classes\Page;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\DatabaseModel;

class Page extends Base
{
    protected array $allPage = [];

    private int $num = 10;
    private int $page = 1;
    private array $pagination = [];

    protected function onInput(): void
    {
        parent::onInput();

        $database = new DatabaseModel();

        $this->title = 'Страницы - ' . $this->title;

        if (isset($_POST['add'])) {
            header('Location: index.php?c=addpage');
            exit;
        }

        $searchText = trim(filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
        $searchField = filter_input(INPUT_POST, 'field', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($searchText !== '') {
            header(
                "Location: index.php?c=find&find=page&field=" . urlencode($searchField) . "&text=" . urlencode(
                    $searchText,
                ),
            );
            exit;
        }

        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $this->page = $page !== false && $page !== null ? $page : 1;

        $totalItems = (int)($database->countPage()['count'] ?? 0);

        if ($totalItems === 0) {
            $this->num = 10;
        } elseif ($totalItems < 10) {
            $this->num = $totalItems;
        } else {
            $this->num = 10;
        }

        $totalPages = (int)ceil($totalItems / $this->num);

        if ($this->page > $totalPages && $totalPages > 0) {
            $this->page = $totalPages;
        }

        $start = max(0, ($this->page - 1) * $this->num);

        $this->allPage = $database->selectAllPage($start, $this->num);

        // Строим массив пагинации
        $this->buildPagination($totalPages);
    }

    private function buildPagination(int $totalPages): void
    {
        $this->pagination = [
            'first' => $this->page > 1 ? 1 : null,
            'prev' => $this->page > 1 ? $this->page - 1 : null,
            'next' => $this->page < $totalPages ? $this->page + 1 : null,
            'last' => $this->page < $totalPages ? $totalPages : null,
            'pages' => array_filter([
                $this->page - 2 > 0 ? $this->page - 2 : null,
                $this->page - 1 > 0 ? $this->page - 1 : null,
                $this->page,
                $this->page + 1 <= $totalPages ? $this->page + 1 : null,
                $this->page + 2 <= $totalPages ? $this->page + 2 : null,
            ]),
            'current' => $this->page,
        ];
    }

    protected function onOutput(): void
    {
        $vars = [
            'allPage' => $this->allPage,
            'num' => $this->num,
            'pagination' => $this->pagination,
        ];

        $this->content = $this->template('templates/v_page.php', $vars);
        parent::onOutput();
    }
}