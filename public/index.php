<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set("display_errors", "1");

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../helpers/ViteAssets.php';

use Classes\ViewMain\ViewMain;

// Заголовки и таймзона
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Novosibirsk');

// Загружаем config
$configPath = __DIR__ . '/../bcms/classes/Config/Config.php';
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

// Получаем хост из собственной переменной MYSQL_HOST, а не из системной HOSTNAME
$host = $_ENV['MYSQL_HOST'] ?? 'db';
$dbName = $_ENV['MYSQL_DATABASE'] ?? '';
$username = $_ENV['MYSQL_USER'] ?? '';
$password = $_ENV['MYSQL_PASSWORD'] ?? '';

// Проверка подключения к БД и наличия таблиц
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

// Роутинг
$controllerName = $_GET['c'] ?? 'view';
$controllerName = htmlspecialchars(trim($controllerName));

// Контроллер
$controller = match ($controllerName) {
    default => new ViewMain(),
};

// Запуск
$controller->Request();