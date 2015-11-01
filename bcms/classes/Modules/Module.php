<?php
/*
 * Module.php - подключение/отключение модулей
 */
namespace bcms\classes\Modules;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\DatabaseModel;

/*
 * Контроллер страницы чтения
 */
class Module extends Base
{
    protected $nameSite = '';
    protected $dbName = '';
    protected $news = '';
    protected $ghost = '';
    protected $review = '';

    /*
     * Виртуальный обработчик запроса
     */
    protected function onInput()
    {
        parent::onInput();

        // Объявляем экземпляры классов для работы с базой данных
        $database = new DatabaseModel();

        // Задаем заголовок для страницы представления
        $this->title = 'Подключаемые модули - ' . $this->title;

        // Загружаем настройки cms из базы данных
        $settings = $database->selectSettings();

        $this->nameSite = $settings['namesite'];
        $this->dbName = DBNAME;
        $this->news = $settings['news'];
        $this->ghost = $settings['ghost'];
        $this->review = $settings['review'];

        $news = filter_input(INPUT_GET, 'news', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (isset($news)) {
            if ($this->news == 1) {
                $this->news = 0;
            } else {
                $this->news = 1;
            }
            $database->updateSettings2($this->news, $this->ghost, $this->review);
            header('Location: index.php?c=modules');
            die();
        }

        $ghost = filter_input(INPUT_GET, 'ghost', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (isset($ghost)) {
            if ($this->ghost == 1) {
                $this->ghost = 0;
            } else {
                $this->ghost = 1;
            }
            $database->updateSettings2($this->news, $this->ghost, $this->review);
            header('Location: index.php?c=modules');
            die();
        }

        $review = filter_input(INPUT_GET, 'review', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (isset($review)) {
            if ($this->review == 1) {
                $this->review = 0;
            } else {
                $this->review = 1;
            }
            $database->updateSettings2($this->news, $this->ghost, $this->review);
            header('Location: index.php?c=modules');
            die();
        }
    }

    /*
     * Виртуальный генератор HTML
     */
    protected function onOutput()
    {
        $vars = array(
            'nameSite' => $this->nameSite, 
            'dbName' => $this->dbName, 
            'news' => $this->news, 
            'ghost' => $this->ghost, 
            'review' => $this->review
        );
        $this->content = $this->template('templates/v_module.php', $vars);
        parent::onOutput();
    }

}