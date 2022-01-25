<?php
/*
 * News.php - модуль новости
 */

namespace Classes\Modules;

use bcms\classes\Database\NewsModel;
use Classes\BaseClass\BaseSecond;

/*
 * Контроллер страницы модуля новости
 */

class News extends BaseSecond
{
    public int $page;
    protected array $allNews; // Все новости

    /*
     * Виртуальный обработчик запроса
     */
    protected function onInput(): void
    {
        parent::onInput();

        $database = new NewsModel();

        $this->title = 'Новости - ' . $this->title;

        if ($this->isPost()) {
            header('Location: index.php?c=addnews');
            exit;
        }

        // Извлекаем из URL текущую страницу (int, минимум 1)
        $page = (int)filter_input(
            INPUT_GET,
            'page',
            FILTER_VALIDATE_INT,
            ['options' => ['default' => 1, 'min_range' => 1]],
        );
        $this->page = $page;

        // Постраничная навигация (закомментирована, можно включить при необходимости)
        /*
        $postsCount = $database->countNews();
        $itemsPerPage = 10;
        $totalPages = (int)ceil($postsCount / $itemsPerPage);

        if ($this->page > $totalPages) {
            $this->page = $totalPages;
        }

        $start = ($this->page - 1) * $itemsPerPage;
        */

        // Проверяем параметр all - если есть, выводим все новости
        $getAll = filter_input(INPUT_GET, 'all', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($getAll !== null) {
            // Выводим все новости (ограничение большое для безопасности)
            $this->allNews = $database->selectAllNews(0, PHP_INT_MAX);
        } else {
            // Выводим первые 10 новостей
            $this->allNews = $database->selectAllNews(0, 10);
        }
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput(): void
    {
        $vars = ['allNews' => $this->allNews];
        $this->content = $this->template('templates/' . $this->settings['template'] . '/v_news.php', $vars);
        parent::onOutput();
    }
}