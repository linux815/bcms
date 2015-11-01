<?php
/*
 * ViewMain.php - основной класс после new Base()
 */
namespace classes\ViewMain;

use \bcms\classes\Database\DatabaseModel;
use \classes\BaseClass\Base;

/*
 * Контроллер страницы чтения
 */

class ViewMain extends Base
{
    protected $nameSite; // Название сайта
    protected $dbName; // Имя базы данных
    protected $content; // содержание страницы
    protected $settings; // настройки cms

    /*
     * Конструктор
     */
    function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /*
     * Виртуальный обработчик запроса
     */

    protected function onInput()
    {
        parent::onInput();

        // Объявляем экземпляры классов для работы с базой данных
        $database = new DatabaseModel();

        // $this->title = 'Главная - ' . $this->title;		
        // Загружаем настройки cms из базы данных
        $settings = $database->selectSettings();

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!isset($id)) {
            header('Location: index.php?c=view&id=1');
        }
        $this->content = $database->selectPageId($id);
        $this->title = $this->content['title'] . ' - Новоозерновская основная общеобразовательная школа';
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput()
    {
        $vars = array(
            'title' => $this->title,
            'nameSite' => $this->nameSite,
            'dbName' => $this->dbName,
            'content' => $this->content,
            'settings' => $this->settings
        );
        $this->content = $this->template('templates/' . $this->settings['template'] . '/v_view.php', $vars);
        parent::onOutput();
    }
}