<?php

declare(strict_types=1);

use bcms\classes\Authorization\Auth;
use bcms\classes\Config\Settings;
use bcms\classes\Confirmation\{Confirm, Delete};
use bcms\classes\JQuery\JQuery;
use bcms\classes\Modules\{Module, Recycle, Review};
use bcms\classes\News\{AddNews, EditNews, News};
use bcms\classes\Page\{AddPage, EditPage, Page};
use bcms\classes\Search\FindPage;
use bcms\classes\Users\{EditUser, Users, ViewUser};
use bcms\classes\ViewMain\ViewMain;

// Установим заголовки и таймзону
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Novosibirsk');

// Подключаем автозагрузчик Composer
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../helpers/ViteAssets.php';

// Загружаем переменные окружения
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
} catch (Throwable) {
    header("Location: /install");
    exit;
}

// Получаем хост из MYSQL_HOST, fallback на 'db'
$host = $_ENV['MYSQL_HOST'] ?? 'db';

// Псевдонимы переменных (для совместимости)
$_ENV['HOSTNAME'] = $host;
$_ENV['DBNAME'] = $_ENV['MYSQL_DATABASE'] ?? '';
$_ENV['USERNAME'] = $_ENV['MYSQL_USER'] ?? '';
$_ENV['PASSWORD'] = $_ENV['MYSQL_PASSWORD'] ?? '';

// Проверка: подключена ли БД и есть ли таблицы
try {
    $dsn = "mysql:host={$host};dbname={$_ENV['DBNAME']};charset=utf8mb4";
    $pdo = new PDO($dsn, $_ENV['USERNAME'], $_ENV['PASSWORD'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $stmt = $pdo->query("SHOW TABLES");
    if (!$stmt->fetchColumn()) {
        header("Location: /install");
        exit;
    }
} catch (Throwable) {
    header("Location: /install");
    exit;
}

// Определяем контроллер
$controllerName = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'view';

$controller = match ($controllerName) {
    'auth' => new Auth(),
    'users' => new Users(),
    'confirm' => new Confirm(),
    'delete' => new Delete(),
    'profile' => new ViewUser(),
    'edituser' => new EditUser(),
    'page' => new Page(),
    'addpage' => new AddPage(),
    'editpage' => new EditPage(),
    'news' => new News(),
    'addnews' => new AddNews(),
    'editnews' => new EditNews(),
    'recycle' => new Recycle(),
    'jquery' => new JQuery(),
    'review' => new Review(),
    'find' => new FindPage(),
    'modules' => new Module(),
    'settings' => new Settings(),
    default => new ViewMain(),
};

// Запускаем контроллер
$controller->Request();