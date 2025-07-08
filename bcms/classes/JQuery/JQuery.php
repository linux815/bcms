<?php
/**
 * JQuery.php — контроллер для обработки AJAX-запросов
 */

namespace bcms\classes\JQuery;

use bcms\classes\BaseClass\BaseSecond;
use bcms\classes\Database\DatabaseModel;

class JQuery extends BaseSecond
{
    protected function onInput(): void
    {
        parent::onInput();

        $database = new DatabaseModel();
        $this->title = 'Главная - ' . $this->title;

        $module = filter_input(INPUT_POST, 'module', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($module !== null) {
            $id = (int)filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            if ($module === 'disable') {
                $database->deleteAllModule($id);
                echo "Все модули удалены";
                return;
            }

            if ($module === '' || $module === 'Выберите модуль для данной страницы') {
                echo "Выберите модуль из списка";
                return;
            }

            $database->addModulePage($id, $module);
            echo "Модуль добавлен";
            return;
        }

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($title) || empty($text)) {
            echo "<p class='error'>Все поля должны быть заполнены.</p>";
            return;
        }

        // Отправка письма администратору
        $subject = $title;
        $body = $text;
        $to = "ivan.bazhenov@gmail.com";

        if (mail($to, $subject, $body)) {
            echo "<p class='success'>Сообщение отправлено.</p>";
        } else {
            echo "<p class='error'>Ошибка при отправке сообщения.</p>";
        }
    }

    protected function onOutput(): void
    {
        $this->content = $this->template('templates/v_jquery.php');
        parent::onOutput();
    }
}