<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_POST['submit'])) {
    header('location: /install');
}

function escape(string $value): string
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

$host = escape($_POST['localhost'] ?? 'db');
$user = escape($_POST['user']);
$password = escape($_POST['password']);
$dbName = escape($_POST['db']);
$email = escape($_POST['email']);
$siteName = escape($_POST['namesite']);

try {
    $dbh = new PDO(
        "mysql:host=$host;",
        $user,
        $password,
        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    );

    $sql = file_get_contents(__DIR__ . '/schema.sql');
    $sql = str_replace(
        ['{{DB}}', '{{SITE_NAME}}', '{{EMAIL}}'],
        [$dbName, $siteName, $email],
        $sql,
    );

    $dbh->exec($sql);
    $dbh = null;

    // Генерация config
    $config = <<<PHP
        <?php
        /*
         * Базовый конфигурационный файл
         */
        define("HOSTNAME", "$host");
        define("USERNAME", "$user");
        define("PASSWORD", "$password");
        define("DBNAME", "$dbName");
        define("EMAIL", "$email");
        PHP;

    file_put_contents(__DIR__ . '/../../bcms/classes/Config/Config.php', $config);
    echo "<center><h1>bCMS успешно установлена!</h1><h3><a href='../bcms/index.php'>Перейти в админку</a></h3></center>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>Ошибка подключения к БД: " . $e->getMessage() . "</p>";
}