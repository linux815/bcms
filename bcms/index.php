<?php
/*
 *  index.php - точка входа
 */
namespace bcms;

//error_reporting(E_ALL ^ E_NOTICE); // Для Unix
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

use \bcms\classes\ViewMain\ViewMain;
use \bcms\classes\Authorization\Auth;
use \bcms\classes\Page\Page;
use \bcms\classes\Page\AddPage;
use \bcms\classes\Page\EditPage;
use \bcms\classes\News\News;
use \bcms\classes\News\AddNews;
use \bcms\classes\News\EditNews;
use \bcms\classes\Users\Users;
use \bcms\classes\Users\ViewUser;
use \bcms\classes\Users\EditUser;
use \bcms\classes\Confirmation\Confirm;
use \bcms\classes\JQuery\JQuery;
use \bcms\classes\Modules\Module;
use \bcms\classes\Modules\Review;
use \bcms\classes\Modules\Recycle;
use \bcms\classes\Config\Settings;
use \bcms\classes\Search\FindPage;
use \bcms\classes\Confirmation\Delete;

/*
 *  Вывод всех ошибок и уведомлений php
 */
// Устанавливаем кодировку
header("Content-Type: text/html; charset=utf-8");

// Устанавливаем часовой пояс по умолчанию 
date_default_timezone_set('Asia/Novosibirsk');

// Регистрируем файлы с расширение .php
spl_autoload_extensions(".php");

// Подключаем наш Autoload
require_once('classes/Autoloader/Autoloader.php');
spl_autoload_register('classes\Autoloader\Autoloader::autoload');

/* @var $getVar получаем отфильтрованное значение $_GET['c'] */
$c = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!isset($c)) {
    $c = 'view';
}

switch ($c) {
    case 'auth':
        $controller = new Auth();
        break;
    case 'users':
        $controller = new Users();
        break;
    case 'confirm':
        $controller = new Confirm();
        break;
    case 'delete':
        $controller = new Delete();
        break;
    case 'profile':
        $controller = new ViewUser();
        break;
    case 'edituser':
        $controller = new EditUser();
        break;
    case 'page':
        $controller = new Page();
        break;
    case 'addpage':
        $controller = new AddPage();
        break;
    case 'editpage':
        $controller = new EditPage();
        break;
    case 'news':
        $controller = new News();
        break;
    case 'addnews':
        $controller = new AddNews();
        break;
    case 'editnews':
        $controller = new EditNews();
        break;
    case 'recycle':
        $controller = new Recycle();
        break;
    case 'jquery':
        $controller = new JQuery();
        break;
    case 'review':
        $controller = new Review();
        break;
    case 'find':
        $controller = new FindPage();
        break;
    case 'modules':
        $controller = new Module();
        break;
    case 'settings':
        $controller = new Settings();
        break;   
    default:
        $controller = new ViewMain();
}

$controller->Request();
