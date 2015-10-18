<?php
/*
 * AddPage.php - добавление страницы
 */
namespace bcms\classes\Page;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\DatabaseModel;

class AddPage extends Base
{

    private $error;

    //
    // Виртуальный обработчик запроса.
    //
	protected function onInput()
    {
        parent::onInput();

        // Объявляем экземпляры классов для работы с базой данных		
        $database = new DatabaseModel();

        // Задаем заголовок для страницы представления		
        $this->title = 'Создание новой страницы - ' . $this->title;

        // Проверка на нажатие кнопки
        if ($this->isPost()) {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($title == "") {
                $this->error = "Введите название страницы.";
            } else {
                $hide = filter_input(INPUT_POST, 'hide', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->error = "";
                $title = trim($title);
                $hide = trim($hide);
                $database->addPage($title, $hide);
                header('Location: index.php?c=page');
            }
        }
    }

    //
    // Виртуальный генератор HTML.
    //	
    protected function onOutput()
    {
        $vars = array('error' => $this->error);
        $this->content = $this->template('templates/v_addpage.php', $vars);
        parent::onOutput();
    }

}