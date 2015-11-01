<?php
/*
 * FindPage.php - поиск
 */
namespace bcms\classes\Search;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\DatabaseModel;

/*
 * Контроллер страницы поиска
 */
class FindPage extends Base
{
	protected $allPage; // Пользователи
    
	/*
	 * Виртуальный обработчик запроса
	 */
	protected function onInput()
	{		
		parent::onInput();
		
		// Объявляем экземпляры классов для работы с базой данных
		$database = new DatabaseModel();		

		// Задаем заголовок для страницы представления
		$this->title = 'Поиск - ' . $this->title;		
	
		$field = filter_input(INPUT_GET, 'field', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$text  = filter_input(INPUT_GET, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$table = filter_input(INPUT_GET, 'find', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		// Выборка пользователей
		$this->allPage = $database->findAll($field, $text, $table);
	}
	
	/*
	 * Виртуальный генератор HTML
	 */
	protected function onOutput()
	{
		$vars = array('allPage' => $this->allPage);	
		
		if ($_GET['find'] == 'page') {
			$this->content = $this->template('templates/v_findPage.php', $vars);
		} elseif ($_GET['find'] == 'users') {
			$this->content = $this->template('templates/v_findUsers.php', $vars);		
		}
		
		parent::onOutput();
	}	
}