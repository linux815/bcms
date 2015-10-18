<?php
/*
 * Recycle.php - корзина
 * =====================
 * Устаревший и небезопасный модуль. Необходимо переписать!
 */
namespace bcms\classes\Modules;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\DatabaseModel;
use \bcms\classes\Database\UserModel;

/*
 * Контроллер страницы чтения
 */

class Recycle extends Base
{

    public $user, $recycle; // Пользователи
    private $num, $pervpage, $page2left, $page1left, $page1right, $page2right, $nextpage;

    /*
     * Виртуальный обработчик запроса
     */

    protected function onInput()
    {
        parent::onInput();

        // Объявляем экземпляры классов для работы с базой данных
        $database = new DatabaseModel();

        // Задаем заголовок для страницы представления
        $this->title = 'Корзина - ' . $this->title;

        $mUsers = UserModel::Instance();

        // Очистка старых сессий.
        $mUsers->ClearSessions();

        // Текущий пользователь.
        $this->user = $mUsers->Get();

        $delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $users  = filter_input(INPUT_POST, 'users', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $page   = filter_input(INPUT_POST, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $news   = filter_input(INPUT_POST, 'news', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (!isset($delete)) {
            header('Location: index.php?c=recycle&delete=page');
            die();
        }

        if (isset($users)) {
            header('Location: index.php?c=recycle&delete=users');
            die();
        }

        if (isset($page)) {
            header('Location: index.php?c=recycle&delete=page');
            die();
        }

        if (isset($news)) {
            header('Location: index.php?c=recycle&delete=news');
            die();
        }

        $table = trim($delete);

        if ($table == "page")
            $table_id = "id_page";
        if ($table == "users")
            $table_id = "id_user";
        if ($table == "news")
            $table_id = "id_news";

        $id_rec = filter_input(INPUT_GET, 'id_rec', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $no_restore = filter_input(INPUT_GET, 'no_restore', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (isset($id_rec) and ( !isset($no_restore))) {
            $database->recoveryRecycleID($id_rec, $table, $table_id);
            header('Location: index.php?c=recycle&delete=' . $table);
            die();
        }

        if (isset($id_rec) and ( isset($no_restore))) {
            $database->deleteRecycleID($id_rec, $table, $table_id);
            header('Location: index.php?c=recycle&delete=' . $table);
            die();
        }

        $del = filter_input(INPUT_POST, 'del', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (isset($del)) {
            $id_num = filter_input(INPUT_POST, 'id_num', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            foreach ($id_num as $num) {
                $database->recoveryRecycleID($num[0], $table, $table_id);
            }
        }

        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        
        // Извлекаем из URL текущую страницу
        if (!isset($page)) {
            $this->page = 1;
        } else {
            $this->page = trim($page);
        }

        // Определяем общее число сообщений в базе данных
        // Количество пользователей
        $posts = $database->countDel($table);
        if ($posts[0] == 0) {
            $posts[0] = 1;
        }
        if ($posts[0] < 10) {
            $this->num = $posts[0];
        } else {
            $this->num = 10;
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
        $this->recycle = $database->selectDel($table, $start, $this->num);

        // Проверяем нужны ли стрелки назад
        if ($this->page != 1) {
            $this->pervpage = '<a href= index.php?c=recycle&delete=' . $table . '&page=1>« В начало</a>
                               <a href= index.php?c=recycle&delete=' . $table . '&page=' . ($this->page - 1) . '>« Назад</a>';
        }
        // Проверяем нужны ли стрелки вперед
        if ($this->page != $total) {
            $this->nextpage = ' <a href= index.php?c=recycle&delete=' . $table . '&page=' . ($this->page + 1) . '>Вперед »</a>
        		                <a href= index.php?c=recycle&delete=' . $table . '&page=' . $total . '>В конец »</a>';
        }

        // Находим две ближайшие станицы с обоих краев, если они есть
        if ($this->page - 2 > 0) {
            $this->page2left = ' <a href= index.php?c=recycle&delete=' . $table . '&page=' . ($this->page - 2) . '>' . ($this->page - 2) . '</a> ';
        }
        if ($this->page - 1 > 0) {
            $this->page1left = '<a href= index.php?c=recycle&delete=' . $table . '&page=' . ($this->page - 1) . '>' . ($this->page - 1) . '</a> ';
        }
        if ($this->page + 2 <= $total) {
            $this->page2right = ' <a href= index.php?c=recycle&delete=' . $table . '&page=' . ($this->page + 2) . '>' . ($this->page + 2) . '</a>';
        }
        if ($this->page + 1 <= $total) {
            $this->page1right = ' <a href= index.php?c=recycle&delete=' . $table . '&page=' . ($this->page + 1) . '>' . ($this->page + 1) . '</a>';
        }
    }
   
    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput()
    {
        $vars = array(
            'user' => $this->user,
            'recycle' => $this->recycle,
            'num' => $this->num,
            'pervpage' => $this->pervpage,
            'page2left' => $this->page2left,
            'page1left' => $this->page1left,
            'page' => $this->page,
            'page1right' => $this->page1right,
            'page2right' => $this->page2right,
            'nextpage' => $this->nextpage
        );

        $delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($delete == "page") {
            $this->content = $this->template('templates/v_recyclePage.php', $vars);
        } elseif ($delete == "users") {
            $this->content = $this->template('templates/v_recycleUser.php', $vars);
        } elseif ($delete == "news") {
            $this->content = $this->template('templates/v_recycleNews.php', $vars);
        } else {
            $this->content = $this->Template('templates/v_recyclePage.php', $vars);
        }

        parent::onOutput();
    }
}