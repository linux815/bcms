<?php
/*
 * Review.php - отзывы
 */
namespace bcms\classes\Modules;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\ReviewModel;

/*
 * Контроллер страницы чтения
 */
class Review extends Base
{
	protected $reviews   = '';
	protected $review_id = ''; 
	
	/*
	 * Виртуальный обработчик запроса
	 */
	protected function onInput()
	{		
		parent::onInput();

		// Объявляем экземпляры классов для работы с базой данных		
		$database = new ReviewModel();		

		// Задаем заголовок для страницы представления		
		$this->title = 'Обратная связь - ' . $this->title;		
		
		$this->reviews = $database->selectReview();	

        $delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
		if (isset($delete)) {
			$id = trim($delete);
			$database->deleteReview($id);
			header('Location: index.php?c=review');
			die();
		}
        
        $view = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		if (isset($view)) {
			$id = htmlspecialchars(trim($view), ENT_QUOTES);
			$this->review_id = $database->selectReviewId($id);
		}
	}
	
	/*
	 * Виртуальный генератор HTML
	 */
	protected function onOutput()
	{
		$vars = array('reviews' => $this->reviews, 'review_id' => $this->review_id);	
		$this->content = $this->template('templates/v_review.php', $vars);
		parent::onOutput();
	}	
}