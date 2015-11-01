<?php
/*
 * Settings.php - настройки MaxiCMS
 */
namespace bcms\classes\Config;

use \bcms\classes\BaseClass\Base;
use \bcms\classes\Database\DatabaseModel;

/*
 * Контроллер страницы чтения
 */

class Settings extends Base 
{
    protected $nameSite = '';
    protected $template = '';
    protected $dbName = '';
    protected $version = '3.0.1.2 Release';
    protected $news = '';
    protected $review = '';
    protected $mUsers = '';
    protected $mdReview = '';
    protected $keywords = '';
    protected $description = '';

    /*
     * Виртуальный обработчик запроса
     */

    protected function onInput() 
    {
        parent::onInput();

        // Объявляем экземпляры классов для работы с базой данных
        $database = new DatabaseModel();

        // Задаем заголовок для страницы представления
        $this->title = 'Настройки - ' . $this->title;

        // Загружаем настройки cms из базы данных
        $settings = $database->selectSettings();

        $this->nameSite  = $settings['namesite'];
        $this->news      = $settings['news'];
        $this->ghost     = $settings['ghost'];
        $this->review    = $settings['review'];
        $this->mUsers   = $settings['m_users'];
        $this->mdReview = $settings['md_review'];
        $this->template = $settings['template'];
        $this->keywords = $settings['keywords'];
        $this->description = $settings['description'];
        
        $menu = filter_input(INPUT_POST, 'menu', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // echo $menu;
        // die();

        if ($this->isPost()) {
            if ($menu == "users") {
                $m_users = 1;
            } else {
                $m_users = 0;
            }
            $this->mdReview = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $template = filter_input(INPUT_POST, 'template', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $nameSite = filter_input(INPUT_POST, 'namesite', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $database->updateSettings($template, $nameSite, $m_users, $this->mdReview, $keywords, $description);
            header('Location: index.php?c=settings');
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
            'version' => $this->version,
            'news' => $this->news,
            'review' => $this->review,
            'm_users' => $this->mUsers,
            'md_review' => $this->mdReview,
            'template' => $this->template,
            'keywords' => $this->keywords,
            'description' => $this->description
        );
        $this->content = $this->template('templates/v_settings.php', $vars);
        parent::onOutput();
    }

}