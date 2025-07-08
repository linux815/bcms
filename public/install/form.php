<?php

// Загрузка переменных из .env (предположим, что dotenv уже установлен)
use App\Helpers\ViteAssets;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../helpers/ViteAssets.php';

$defaults = [
    'localhost' => 'localhost',
    'user' => '',
    'password' => '',
    'db' => '',
    'email' => '',
    'namesite' => 'Мой сайт',
];

// Попытка загрузить из .env
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
    $dotenv->load();
    $defaults['localhost'] = $_ENV['MYSQL_HOST'] ?? $defaults['localhost'];
    $defaults['user'] = $_ENV['MYSQL_USER'] ?? $defaults['user'];
    $defaults['password'] = $_ENV['MYSQL_PASSWORD'] ?? $defaults['password'];
    $defaults['db'] = $_ENV['MYSQL_DATABASE'] ?? $defaults['db'];
    // email и namesite могут быть из других мест, оставим так
} catch (Throwable) {
    // Игнорируем ошибки загрузки .env
}

// Если форма отправлена, и есть ошибки, подставляем значения из POST для удобства
$old = $_POST;

$viteAssets = new ViteAssets(
    __DIR__ . '/../../public/assets/manifest.json',
);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Установка bCMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= $viteAssets->css('css/main.css') ?>

    <script type="module" src="<?= htmlspecialchars($viteAssets->asset('js/main.js'), ENT_QUOTES, 'UTF-8') ?>"></script>

    <!-- Пользовательский CSS -->
    <?= $viteAssets->css('css/custom.css') ?>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-wrapper {
            max-width: 700px;
            margin: 5% auto;
            background: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-wrapper">
        <h1 class="mb-4 text-center">Установка <span class="text-primary">bCMS</span></h1>
        <p class="text-center mb-4">Заполните все поля ниже для установки системы.</p>

        <form method="post" class="needs-validation" novalidate action="install.php">
            <div class="mb-3">
                <label for="input-localhost" class="form-label">Хост</label>
                <input type="text" name="localhost" class="form-control" id="input-localhost" placeholder="localhost"
                       required
                       value="<?= htmlspecialchars($old['localhost'] ?? $defaults['localhost']) ?>">
                <div class="invalid-feedback">Укажите хост (обычно localhost).</div>
            </div>

            <div class="mb-3">
                <label for="input-user" class="form-label">Пользователь</label>
                <input type="text" name="user" class="form-control" id="input-user" required
                       value="<?= htmlspecialchars($old['user'] ?? $defaults['user']) ?>">
                <div class="invalid-feedback">Укажите имя пользователя БД.</div>
            </div>

            <div class="mb-3">
                <label for="input-password" class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" id="input-password" required
                       value="<?= htmlspecialchars($old['password'] ?? $defaults['password']) ?>">
                <div class="invalid-feedback">Укажите пароль БД.</div>
            </div>

            <div class="mb-3">
                <label for="input-db" class="form-label">Имя базы данных</label>
                <input type="text" name="db" class="form-control" id="input-db" required
                       value="<?= htmlspecialchars($old['db'] ?? $defaults['db']) ?>">
                <div class="invalid-feedback">Укажите имя базы данных.</div>
            </div>

            <div class="mb-3">
                <label for="input-email" class="form-label">Email администратора</label>
                <input type="email" name="email" class="form-control" id="input-email" required
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                <div class="invalid-feedback">Введите корректный email.</div>
            </div>

            <div class="mb-3">
                <label for="input-namesite" class="form-label">Название сайта</label>
                <input type="text" name="namesite" class="form-control" id="input-namesite" placeholder="Мой сайт"
                       value="<?= htmlspecialchars($old['namesite'] ?? $defaults['namesite']) ?>">
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100" id="submit-btn">
                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"
                      id="spinner"></span>
                <span id="btn-text">Установить</span>
            </button>
        </form>
    </div>
</div>

<script>
    // Bootstrap 5 валидация форм
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                } else {
                    // Если форма валидна, покажем спиннер и заблокируем кнопку
                    const submitBtn = form.querySelector('#submit-btn');
                    const spinner = form.querySelector('#spinner');
                    const btnText = form.querySelector('#btn-text');
                    if (submitBtn && spinner && btnText) {
                        submitBtn.disabled = true;
                        spinner.classList.remove('d-none');
                        btnText.textContent = 'Установка...';
                    }
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

</body>
</html>