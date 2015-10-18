<?php
/*
 * AddNews.php - добавление новости
 */ 
namespace bcms\classes\News;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\NewsModel;

class AddNews extends Base
{
	private $error;

	//
	// Виртуальный обработчик запроса.
	//
	protected function onInput()
	{
		parent::onInput();
		
		// Объявляем экземпляры классов для работы с базой данных		
		$database = new NewsModel();

		// Задаем заголовок для страницы представления		
		$this->title = 'Добавление новости - ' . $this->title;		
				
		// Проверка на нажатие кнопки
		if ($this->isPost()) {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			if ($title == "") {
				$this->error = "Введите заголовок.";
			} else {
				$this->error = "";
				$title = trim($title);
				$text  = $_POST['content'];
				$database->addNews($title, $text);
				header('Location: index.php?c=news');
			}
		}
	}
	
	//
	// Виртуальный генератор HTML.
	//	
	protected function onOutput()
	{
		$vars = array('error' => $this->error);	
		$this->content = $this->template('templates/v_addnews.php', $vars);
		parent::onOutput();
	}		
}