<?php
error_reporting(E_ALL & E_NOTICE);
ini_set("display_errors", 1);
error_reporting (E_ALL ^ E_NOTICE); // Для Unix
error_reporting(E_ALL);
ini_set("display_errors", 1);
require __DIR__.'/vendor/autoload.php';

die('ddd');

//
//use classes\ViewMain\ViewMain;
//use classes\Modules\Ghost;
//use classes\Modules\Review;
//use classes\Authorization\Auth;
//use classes\Page\Page;
//use classes\Page\AddPage;
//use classes\Page\EditPage;
//use classes\News\News;
//use classes\News\AddNews;
//use classes\News\EditNews;
//use classes\Users\Users;
//use classes\Users\ViewUser;
//use classes\Users\EditUser;
//use classes\Confirmation\Confirm;
//use classes\JQuery\JQuery;
//use classes\Modules\Module;
//use classes\Modules\Recycle;
//use classes\Config\Settings;
//use classes\Search\FindPage;
//use classes\Confirmation\Delete;
//
//spl_autoload_extensions(".php"); // comma-separated list spl_autoload_register();
//
//header("Content-Type: text/html; charset=utf-8");
//date_default_timezone_set('Asia/Novosibirsk');
//
//require_once('bcms/classes/Autoloader/Autoloader.php');
//spl_autoload_register('classes\Autoloader\Autoloader::autoload');
///*
// * ToDo:
// * 	1. Проверить код на актуальность.
// * 	2. Проверить базу и файлы на наличие utf8
// */
//header("Content-Type: text/html; charset=utf-8");
//date_default_timezone_set('Asia/Novosibirsk');
//
//if (!isset($_GET['c'])) {
//	$c = 'view';
//} else {
//	$c = htmlspecialchars(trim($_GET['c']));
//}
//
//switch ($c)
//{
//case 'auth':
//	$controller = new C_Auth();
//	break;
//case 'users':
//	$controller = new C_Users();
//	break;
//case 'confirm':
//	$controller = new C_Confirm();
//	break;
//case 'delete':
//	$controller = new C_Delete();
//	break;
//case 'profile':
//	$controller = new C_ViewUser();
//	break;
//case 'edituser':
//	$controller = new C_EditUser();
//	break;
//case 'page':
//	$controller = new C_Page();
//	break;
//case 'addpage':
//	$controller = new C_AddPage();
//	break;
//case 'editpage':
//	$controller = new C_EditPage();
//	break;
//case 'news':
//	$controller = new C_News();
//	break;
//case 'addnews':
//	$controller = new C_AddNews();
//	break;
//case 'editnews':
//	$controller = new C_EditNews();
//	break;
//case 'recycle':
//	$controller = new C_Recycle();
//	break;
//case 'review':
//	$controller = new Review();
//	break;
//case 'ghost':
//	$controller = new Ghost();
//	break;
//default:
//	$controller = new ViewMain();
//}
//
//$controller->Request();
