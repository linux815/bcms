<?php
/*
 * ViewUser.php - просмотр пользователя
 */
namespace bcms\classes\Users;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\UserModel;

/*
 * Контроллер страницы просмотра пользователя
 */
class ViewUser extends Base
{
	public $user, $userID; // Пользователи
	private $session;

	/*
	 * Виртуальный обработчик запроса
	 */
	protected function onInput()
	{		
		parent::onInput();

		// Задаем заголовок для страницы представления			
		$this->title = 'Информация о пользователе - ' . $this->title;		
		
		// Менеджеры.
		$mUsers = UserModel::Instance();
		
		// Текущий пользователь.
		$this->user = $mUsers->Get();
		
		$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$id_post = $id;
		
		$this->userID = $mUsers->selectUserID($id);

		$this->session = $mUsers->selectUserSession($id);
		
        $close = filter_input(INPUT_POST, 'Close', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
		if (isset($close)) {
			header('Location: index.php?c=users');
			die();
		}
		
        $edit = filter_input(INPUT_POST, 'Edit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
		if (isset($edit)) {
			header('Location: index.php?c=edituser&id='.$id_post);
			die();
		}
		
        $delete = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
		if (isset($delete)) {
			header('Location: index.php?c=confirm&delete=users&id='.$id_post);
			die();
		}
        
        $block = filter_input(INPUT_POST, 'Block', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		if (isset($block)) {
			echo "<script>alert('Функция разблокируется предположительно в версии 3.0.1')</script>";
		}
		
	}
	
	/*
	 * Виртуальный генератор HTML
	 */
	protected function onOutput()
	{
		$vars = array('user' => $this->user, 'userID' => $this->userID, 'session' => $this->session);	
		$this->content = $this->template('templates/v_viewUser.php', $vars);
		parent::onOutput();
	}	
}