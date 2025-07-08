<?php
/*
 * News.php - вывод новостей
 * =========================
 * Устаревший модуль. Необходимо обновить
 */

namespace bcms\classes\News;

use bcms\classes\BaseClass\Base;
use bcms\classes\Database\NewsModel;

class News extends Base
{
    protected array $allNews = [];
    private int $num = 10;
    private int $page = 1;
    private array $pagination = [];

    protected function onInput(): void
    {
        parent::onInput();

        $database = new NewsModel();

        $this->title = 'Новости - ' . $this->title;

        if (isset($_POST['add'])) {
            header('Location: index.php?c=addnews');
            exit;
        }

        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $this->page = $page !== false && $page !== null && $page > 0 ? $page : 1;

        // Метод countNews должен возвращать число, не массив
        $totalItems = (int)($database->countNews()['count'] ?? 0);

        // Определяем количество новостей на страницу (если всего меньше 10, показываем все)
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

        $this->allNews = $database->selectAllNews($start, $this->num);

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
            'allNews' => $this->allNews,
            'num' => $this->num,
            'pagination' => $this->pagination,
        ];

        $this->content = $this->template('templates/v_news.php', $vars);
        parent::onOutput();
    }
}