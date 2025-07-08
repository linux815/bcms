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

// Загружаем .env
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (Throwable) {
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
    $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Проверяем, есть ли таблицы в базе
    $stmt = $pdo->query("SHOW TABLES");
    $hasTables = $stmt->fetchColumn();

    if (!$hasTables) {
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