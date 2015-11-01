<?php
/*
 * Page.php - вывод страниц
 * ========================
 * Устаревший модуль. Необходимо обновить!
 */
namespace bcms\classes\Page;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\DatabaseModel;

/*
 * Контроллер страницы чтения
 */
class Page extends Base
{

    protected $allPage;
    private $num, $pervpage, $page2left, $page1left, $page1right, $page2right, $nextpage, $page;

    /*
     * Виртуальный обработчик запроса
     */
    protected function onInput()
    {
        parent::onInput();

        // Объявляем экземпляры классов для работы с базой данных		
        $database = new DatabaseModel();

        // Задаем заголовок для страницы представления	
        $this->title = 'Страницы - ' . $this->title;

        if (isset($_POST['add'])) {
            header('Location: index.php?c=addpage');
            die();
        }

        $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (isset($search)) {
            $field = filter_input(INPUT_POST, 'field', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            header('Location: index.php?c=find&find=page&field=' . $field . '&text=' . $text);
            die();
        }

        // Извлекаем из URL текущую страницу
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!isset($page)) {
            $this->page = 1;
        } else {
            $this->page = trim($page);
        }

        // Определяем общее число сообщений в базе данных
        // Количество пользователей
        $posts = $database->countPage();
        if ($posts[0] < 10) {
            if ($posts[0] == 0) {
               $this->num = 1; 
            } else {
                $this->num = $posts[0];
            }
        } else {
            $this->num = 20;
        }

        // Находим общее число страниц
        $total = intval(($posts[0] - 1) / $this->num) + 1;

        // Определяем начало сообщений для текущей страницы
        $this->page = intval($this->page);

        // Если значение $page меньше единицы или отрицательно
        // переходим на первую страницу
        // А если слишком большое, то переходим на последнюю
        if (empty($this->page) or $this->page < 0) {
            $this->page = 1;
        }
        if ($this->page > $total) {
            $this->page = $total;
        }

        // Вычисляем начиная к какого номера
        // следует выводить сообщения
        $start = $this->page * $this->num - $this->num;

        // Выбираем $num сообщений начиная с номера $start
        // В цикле переносим результаты запроса в массив $postrow
        // Выборка пользователей
        $this->allPage = $database->selectAllPage($start, $this->num);

        // Проверяем нужны ли стрелки назад
        if ($this->page != 1) {
            $this->pervpage = '<a href= index.php?c=page&page=1>« В начало</a>
                               <a href= index.php?c=page&page=' . ($this->page - 1) . '>« Назад</a> ';
        }
        // Проверяем нужны ли стрелки вперед
        if ($this->page != $total) {
            $this->nextpage = ' <a href= index.php?c=page&page=' . ($this->page + 1) . '>Вперед »</a>
        		                <a href= index.php?c=page&page=' . $total . '>В конец »</a>';
        }

        // Находим две ближайшие станицы с обоих краев, если они есть
        if ($this->page - 2 > 0) {
            $this->page2left = ' <a href= index.php?c=page&page=' . ($this->page - 2) . '>' . ($this->page - 2) . '</a> ';
        }
        if ($this->page - 1 > 0) {
            $this->page1left = '<a href= index.php?c=page&page=' . ($this->page - 1) . '>' . ($this->page - 1) . '</a> ';
        }
        if ($this->page + 2 <= $total) {
            $this->page2right = ' <a href= index.php?c=page&page=' . ($this->page + 2) . '>' . ($this->page + 2) . '</a>';
        }
        if ($this->page + 1 <= $total) {
            $this->page1right = ' <a href= index.php?c=page&page=' . ($this->page + 1) . '>' . ($this->page + 1) . '</a>';
        }
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput()
    {
        $vars = array(
            'allPage' => $this->allPage,
            'num' => $this->num,
            'pervpage' => $this->pervpage,
            'page2left' => $this->page2left,
            'page1left' => $this->page1left,
            'page1' => $this->page,
            'page1right' => $this->page1right,
            'page2right' => $this->page2right,
            'nextpage' => $this->nextpage
        );
        $this->content = $this->Template('templates/v_page.php', $vars);
        parent::onOutput();
    }

}