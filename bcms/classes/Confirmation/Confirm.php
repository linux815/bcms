<?php
/*
 * Confirm.php - класс для подтверждения чего-либо
 */
namespace bcms\classes\Confirmation;

use \bcms\classes\BaseClass\Base;

class Confirm extends Base 
{
    private $char = '';

    //
    // Виртуальный обработчик запроса.
    //
    protected function onInput() 
    {
        parent::onInput();

        // Задаем заголовок для страницы представления
        $this->title = 'Подтверждение - ' . $this->title;

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $delete = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        switch ($delete) {
            case 'users':
                $this->char = "Вы действительно хотите удалить данного пользователя?";
                break;
            case 'page':
                $this->char = "Вы действительно хотите удалить данную страницу?";
                break;
            case 'news':
                $this->char = "Вы действительно хотите удалить данную новость?";
                break;
            default:
                header('Location: index.php');
        }
        
        $buttonYes = filter_input(INPUT_POST, 'Yes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $buttonNo  = filter_input(INPUT_POST, 'No', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (isset($buttonYes)) {
            switch ($delete) {
                case 'users':
                    header('Location: index.php?c=delete&delete=users&id=' . $id);
                    break;
                case 'page':
                    header('Location: index.php?c=delete&delete=page&id=' . $id);
                    break;
                case 'news':
                    header('Location: index.php?c=delete&delete=news&id=' . $id);
                    break;
                default:
                    header('Location: index.php');
            }
        }

        if (isset($buttonNo)) {
            switch ($delete) {
                case 'users':
                    header('Location: index.php?c=users');
                    break;
                case 'page':
                    header('Location: index.php?c=page');
                    break;
                case 'news':
                    header('Location: index.php?c=news');
                    break;
                default:
                    header('Location: index.php');
            }
        }
    }

    //
    // Виртуальный генератор HTML.
    //	
    protected function onOutput() 
    {
        $vars = array('char' => $this->char);
        $this->content = $this->template('templates/v_confirm.php', $vars);
        parent::onOutput();
    }
}
