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

// Composer Autoload + viteAssets helper
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../helpers/ViteAssets.php';

// Загружаем config
$configPath = __DIR__ . '/../../bcms/classes/Config/Config.php';
if (!file_exists($configPath)) {
    header("Location: /install");
    exit;
}

require_once $configPath;

// Проверка необходимых констант
if (!defined('HOSTNAME') || !defined('USERNAME') || !defined('PASSWORD') || !defined('DBNAME')) {
    header("Location: /install");
    exit;
}

// Проверка подключения к БД и таблиц
try {
    $dsn = "mysql:host=" . HOSTNAME . ";dbname=" . DBNAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, USERNAME, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $requiredTables = ['users', 'settings', 'page'];
    $placeholders = rtrim(str_repeat('?,', count($requiredTables)), ',');
    $sql = "SELECT table_name FROM information_schema.tables 
            WHERE table_schema = ? AND table_name IN ($placeholders)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([DBNAME, ...$requiredTables]);
    $foundTables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $missingTables = array_diff($requiredTables, $foundTables);

    if (!empty($missingTables)) {
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

// Запуск контроллера
$controller->Request();