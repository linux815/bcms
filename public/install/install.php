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
    echo <<<HTML
<div style="max-width: 600px; margin: 80px auto; text-align: center; font-family: sans-serif; border: 1px solid #ddd; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
    <h1 style="color: #28a745; margin-bottom: 1rem;">bCMS успешно установлена!</h1>
    <a href="../bcms/index.php" style="display: inline-block; background: #007bff; color: white; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-size: 1.1rem;">
        Перейти в админку
    </a>
</div>
HTML;
} catch (PDOException $e) {
    echo "<p style='color: red;'>Ошибка подключения к БД: " . $e->getMessage() . "</p>";
}