<?php
/*
 * EditPage.php - редактирование страницы
 */
namespace bcms\classes\Page;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\DatabaseModel;

class EditPage extends Base
{

    private $error, $page;

    //
    // Виртуальный обработчик запроса.
    //
	protected function onInput()
    {
        parent::onInput();

        // Объявляем экземпляры классов для работы с базой данных		
        $database = new DatabaseModel();

        // Задаем заголовок для страницы представления	
        $this->title = 'Редактирование страницы - ' . $this->title;

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!isset($id)) {
            header('Location: index.php?c=page');
        } else {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        }

        if ($id)
            $this->page = $database->selectPageId($id);
        else
            $this->error = "Введите корректный номер страницы";

        if ($this->isPost()) {
            $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            if ($title == "") {
                $this->error = "Введите название страницы.";
            } else {
                $this->error = "";
                $text = $_POST['content'];
                $html = 0;
                $database->pageUpdate($id, $title, $text, $html);
                header('Location: index.php?c=page');
            }
        }
    }

    //
    // Виртуальный генератор HTML.
    //	
    protected function onOutput()
    {
        $vars = array('error' => $this->error, 'page' => $this->page);
        $this->content = $this->template('templates/v_editpage.php', $vars);
        parent::onOutput();
    }
}