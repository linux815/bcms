<?php
/*
 * EditUser.php - редактирование пользователя
 */
namespace bcms\classes\Users;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\UserModel;

/*
 * Контроллер страницы редактирования пользователя
 */
class EditUser extends Base
{
	protected $user, $userID; // Пользователи
	private $error;	// сообщение об ошибке
	
	/*
	 * Виртуальный обработчик запроса
	 */
	protected function onInput()
	{		
		parent::OnInput();

		// Задаем заголовок для страницы представления		
		$this->title = 'Редактирование профиля - ' . $this->title;		
		
		// Менеджеры.
		$mUsers = UserModel::Instance();
		
		// Текущий пользователь.
		$this->user = $mUsers->Get();
		
		$id = htmlspecialchars(trim($_GET['id']));

		$this->userID = $mUsers->selectUserID($id);

		if (isset($_POST['SaveInfo'])) {
			$password = htmlspecialchars(trim($_POST['password']));
			$password_apply = htmlspecialchars(trim($_POST['password_apply']));
			
			if ($password_apply == "") {
				$pass = $this->userID['password'];
			} elseif ($password_apply != "") {
				if ($password == $password_apply) {
					$pass = md5($_POST['password']);
				} else {
					$this->error = "Пароли не совпадают!";
				}
			}

			// Путь к аватарке
			preg_match('|<p.*?>(.*)</p>|sei', $_POST['avatar'], $arr);
			$avatar1 = $arr[1];
			$dom = new DOMDocument;
			$dom->loadHTML($avatar1);
			foreach ($dom->getElementsByTagName('img') as $node) {
				$avatar2 = $node->getAttribute( 'src' );
		    } 
			
			if (@$avatar2 == null) {
				$avatar = $avatar1;
			} else {
				$avatar = $avatar2;  
			}
			
			$name = htmlspecialchars(trim($_POST['name']));
			$surname = htmlspecialchars(trim($_POST['surname']));
			$email = htmlspecialchars(trim($_POST['email']));
			$lastname = htmlspecialchars(trim($_POST['lastname']));
			$sex = htmlspecialchars(trim($_POST['sex']));
			$city = htmlspecialchars(trim($_POST['city']));
			$mobile_phone = htmlspecialchars(trim($_POST['mobile_phone']));
			$work_phone = htmlspecialchars(trim($_POST['work_phone']));
			$skype = htmlspecialchars(trim($_POST['skype']));
			$date = $_POST['birth_date'];
			$date = substr($date, 6, 10)."-".substr($date, 3, 2)."-".substr($date, 0, 2);
			$mUsers->editUserInfo(
				$id, 
				$pass, 
				$name, 
				$surname, 
				$email, 
				$lastname, 
				$avatar, 
				$date, 
				$sex, 
				$city, 
				$mobile_phone, 
				$work_phone, 
				$skype
			);
			header('Location: index.php?c=profile&id='.$_GET['id'].'');
		}

		if (isset($_POST['Close'])) {
			header('Location: index.php?c=users');
			die();
		}
		
		if (isset($_POST['Delete'])) {
			header('Location: index.php?c=confirm&delete=users&id='.$_POST['id']);
			die();
		}
		
		if (isset($_POST['Block'])) {
			echo "<script>alert('Функция разблокируется предположительно в версии 3.0.1')</script>";
		}
	}
	
	/*
	 * Виртуальный генератор HTML
	 */
	protected function onOutput()
	{
		$vars = array('user' => $this->user, 'userID' => $this->userID, 'error' => $this->error);	
		$this->content = $this->template('templates/v_editUser.php', $vars);
		parent::onOutput();
	}	
}