<?php
// upload_image.php

// Папка для сохранения изображений
$uploadDir = '../uploads/';
$targetDir = __DIR__ . '/' . $uploadDir;

// Создание директории, если не существует
if (!is_dir($targetDir)) {
    if (!mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create upload directory']);
        exit;
    }
}

// Проверка файла
if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded or upload error']);
    exit;
}

// Проверка MIME-типа
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $_FILES['file']['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedMimeTypes, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Недопустимый тип файла']);
    exit;
}

// Генерация безопасного имени файла
$originalName = basename($_FILES['file']['name']);
$extension = pathinfo($originalName, PATHINFO_EXTENSION);
$sanitizedName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
$finalFileName = time() . '_' . $sanitizedName . '.' . $extension;
$finalPath = $targetDir . $finalFileName;

// Перемещаем файл
if (!move_uploaded_file($_FILES['file']['tmp_name'], $finalPath)) {
    http_response_code(500);
    echo json_encode(['error' => 'Не удалось сохранить файл']);
    exit;
}

// Формируем абсолютный путь для вставки в TinyMCE
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$baseUrl = $protocol . '://' . $host . dirname($_SERVER['PHP_SELF']) . '/';
$imageUrl = $baseUrl . $uploadDir . $finalFileName;

echo json_encode(['location' => $imageUrl]);