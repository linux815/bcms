<?php
/*
 * EditNews.php - редактирование новости
 */ 
namespace bcms\classes\News;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\NewsModel;

class EditNews extends Base
{
	private $error, $news;
	
	//
	// Конструктор.
	//
	function __construct()
	{		
	}
	
	//
	// Виртуальный обработчик запроса.
	//
	protected function onInput()
	{
		parent::onInput();
		
		// Объявляем экземпляры классов для работы с базой данных		
		$database = new NewsModel();

		// Задаем заголовок для страницы представления		
		$this->title = 'Редактирование новости - ' . $this->title;	

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
		if (!isset($id)) {
			header('Location: index.php?c=news');
		} else {	
			$id = trim($id);
		}
		
		$this->news = $database->selectNewsId($id)->fetch();
		
		if ($this->isPost())
		{
			$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			if ($title == "")
			{
				$this->error = "Введите заголовок.";
			}
			else {
				$this->error = "";
				$text = $_POST['content'];
				$html = 0;
				$database->newsUpdate($id, $title, $text);
				header('Location: index.php?c=news');
			}
		}
	}
	
	//
	// Виртуальный генератор HTML.
	//	
	protected function onOutput()
	{
		$vars = array('error' => $this->error, 'news' => $this->news);	
		$this->content = $this->template('templates/v_editnews.php', $vars);
		parent::onOutput();
	}		
}