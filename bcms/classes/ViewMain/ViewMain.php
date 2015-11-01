<?php
/*
 * ViewMain.php - основной класс после new Base()
 */
namespace bcms\classes\ViewMain;

use \bcms\classes\Database\DatabaseModel;
use \bcms\classes\BaseClass\Base;

require_once($_SERVER['DOCUMENT_ROOT'].'/bcms/classes/Config/Config.php');

/*
 * Контроллер страницы
 */
class ViewMain extends Base
{
	protected $nameSite = '';
	protected $dbName   = '';
	
	/*
	 * Виртуальный обработчик запроса
	 */
	protected function onInput()
	{		
		parent::onInput();
		
		// Объявляем экземпляры классов для работы с базой данных
		$database = new DatabaseModel();		

		// Задаем заголовок для страницы представления
		$this->title = 'Главная - ' . $this->title;		

		// Загружаем настройки cms из базы данных
		$settings = $database->selectSettings();
		
		$this->nameSite = $settings['namesite'];
		$this->dbName = DBNAME;	
	}
	
	/*
	 * Виртуальный генератор HTML
	 */
	protected function onOutput()
	{
		$vars = array('nameSite' => $this->nameSite, 'dbName' => $this->dbName);	
		$this->content = $this->template('templates/v_view.php', $vars);
		parent::onOutput();
	}	
}