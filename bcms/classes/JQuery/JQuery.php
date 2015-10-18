<?php
/*
 * JQuery.php - обработчик запросов ajax
 */
namespace bcms\classes\JQuery;

use \bcms\classes\BaseClass\BaseSecond;
use \bcms\classes\Database\DatabaseModel;

/*
 * Контроллер страницы чтения
 */
class JQuery extends BaseSecond 
{
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

        // Подключение модулей для страницы
        $module = filter_input(INPUT_POST, 'module', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (isset($module)) {
            $id = trim(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            if ($module == "disable") {
                $database->deleteAllModule($id);
                echo "Все модули удалены";
            } elseif ($module == "Выберите модуль для данной страницы" or $module == "") {
                echo "Выберите модуль из списка";
            } else {
                $database->addModulePage($id, $module);
                echo "Модуль добавлен";
            }
        } else {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($title == "" or $text == "") {
                echo "<p class='error'>Все поля должны быть заполнены.</p>";
            } else {
                /*
                  // строка, которую будем записывать
                  $text = $title."\n".$text."\n----------------\n";

                  // открываем файл, если файл не существует,
                  // делается попытка создать его
                  $fp = fopen("source/callback/file.txt", "a+");

                  // записываем в файл текст
                  fwrite($fp, $text);

                  // закрываем
                  fclose($fp);
                 */
                mail("ivan.bazhenov@gmail.com", "" . $title . "", "" . $text . "");
                echo "<p class='success'>Сообщение отправлено.</p>";
            }
        }
    }

    /*
     * Виртуальный генератор HTML
     */

    protected function onOutput() 
    {
        $vars = array();
        $this->content = $this->template('templates/v_jquery.php', $vars);
        parent::onOutput();
    }
}