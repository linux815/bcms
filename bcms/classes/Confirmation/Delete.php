<?php
/*
 * Delete.php - удаление чего-либо (пользователи, страницы, новости)
 */
namespace bcms\classes\Confirmation;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\UserModel;
use \bcms\classes\Database\DatabaseModel;
use \bcms\classes\Database\NewsModel;

//
// Контроллер удаления данных
//
class Delete extends Base 
{
    //
    // Виртуальный обработчик запроса.
    //
    protected function onInput() 
    {
        parent::onInput();

        // Объявляем экземпляры классов для работы с базой данных
        $database = new DatabaseModel();
        $db = new NewsModel();
        $mUsers = new UserModel();

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        switch ($delete) {
            case 'users':
                if ($id == "1") {
                    header('Location: index.php?c=users');
                } else {
                    $mUsers->deleteUser($id);
                    header('Location: index.php?c=users');
                }
                break;
            case 'page':
                if ($id == "1") {
                    header('Location: index.php?c=page');
                } else {
                    $database->deletePage($id);
                    header('Location: index.php?c=page');
                }
                break;
            case 'news':
                $db->deleteNews($id);
                header('Location: index.php?c=news');
                break;
            default:
                header('Location: index.php');
        }
    }

    //
    // Виртуальный генератор HTML.
    //	
    protected function onOutput() 
    {
        // $vars = array();	
        // $this->content = $this->Template('templates/v_users.php', $vars);
        parent::onOutput();
    }
}