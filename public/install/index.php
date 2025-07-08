<?php

// Автозагрузка и ошибки
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Проверка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    require_once __DIR__ . '/install.php';
} else {
    require_once __DIR__ . '/form.php';
}