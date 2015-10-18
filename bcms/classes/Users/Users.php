<?php
/*
 * Users.php - вывод пользователей
 * ===============================
 * Устаревший модуль. Необходимо обновить!
 */ 
namespace bcms\classes\Users;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\UserModel;

/*
 * Контроллер страницы вывода пользователей
 */
class Users extends Base
{
	protected $user, $allUsers; // Пользователи
	private $num, $pervpage, $page2left, $page1left, $page1right, $page2right, $nextpage;
	
	/*
	 * Виртуальный обработчик запроса
	 */
	protected function onInput()
	{		
		parent::onInput();

		// Задаем заголовок для страницы представления		
		$this->title = 'Пользователи - ' . $this->title;		
		
		// Менеджеры.
		$mUsers = UserModel::Instance();
		
		// Текущий пользователь.
		$this->user = $mUsers->Get();
		
        $del = filter_input(INPUT_POST, 'del', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
		if (isset($del)) {
			if (!isset($_POST['id_num'])) {
				
			} else {	
				if (is_array($_POST['id_num'])) {
					$id_num = $_POST['id_num'];
					foreach ($id_num as $num) {
						$mUsers->deleteUser($num[0]);
					}
				}	
			}
		}

        $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
		if (isset($search)) {
            $field = filter_input(INPUT_POST, 'field', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text  = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			header('Location: index.php?c=find&find=users&field='.$field.'&text='.$text);
			die();
		}
		
        $delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
		if (!isset($delete)) {
			$delete = '';
		} else {	
			$delete = trim($delete);
		}	
	
		if ($delete == "ALL") {
			$mUsers->deleteUserALL();
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
		$posts = $mUsers->countUser();
		
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
		if(empty($this->page) or $this->page < 0) {
			$this->page = 1;
		}	
		if($this->page > $total) {
			$this->page = $total;
		}
		
		// Вычисляем начиная к какого номера
		// следует выводить сообщения
		$start = $this->page * $this->num - $this->num;
		
		// Выбираем $num сообщений начиная с номера $start
		// В цикле переносим результаты запроса в массив $postrow
		// Выборка пользователей
		$this->allUsers = $mUsers->selectUser($start, $this->num);
		
		// Проверяем нужны ли стрелки назад
		if ($this->page != 1) {
			$this->pervpage = '<a href= index.php?c=users&page=1>« В начало</a>
                               <a href= index.php?c=users&page='. ($this->page - 1) .'>« Назад</a> ';
		}		
		// Проверяем нужны ли стрелки вперед
		if ($this->page != $total) {
			$this->nextpage = ' <a href= index.php?c=users&page='. ($this->page + 1) .'>Вперед »</a>
        		                <a href= index.php?c=users&page=' .$total. '>В конец »</a>';
		}
		
		// Находим две ближайшие станицы с обоих краев, если они есть
		if($this->page - 2 > 0) {
			$this->page2left = ' <a href= index.php?c=users&page='. ($this->page - 2) .'>'. ($this->page - 2) .'</a> ';
		}	
		if($this->page - 1 > 0) {
			$this->page1left = '<a href= index.php?c=users&page='. ($this->page - 1) .'>'. ($this->page - 1) .'</a> ';
		}	
		if($this->page + 2 <= $total) {
			$this->page2right = ' <a href= index.php?c=users&page='. ($this->page + 2) .'>'. ($this->page + 2) .'</a>';
		}	
		if($this->page + 1 <= $total) {
			$this->page1right = ' <a href= index.php?c=users&page='. ($this->page + 1) .'>'. ($this->page + 1) .'</a>';
        }			
	}
	
	/*
	 * Виртуальный генератор HTML
	 */
	protected function onOutput()
	{
		$vars = array(
			'user' => $this->user, 
			'allUsers' => $this->allUsers, 
			'num' => $this->num, 
			'pervpage' => $this->pervpage, 
			'page2left' => $this->page2left, 
			'page1left' => $this->page1left, 
			'page' => $this->page, 
			'page1right' => $this->page1right, 
			'page2right' => $this->page2right, 
			'nextpage' => $this->nextpage
		);	
		$this->content = $this->template('templates/v_users.php', $vars);
		parent::onOutput();
	}	
}