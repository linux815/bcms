<?php

$c = $_GET['c'] ?? '';
$id = $_GET['id'] ?? '';
$delete = $_GET['delete'] ?? '';

$subNav = [
    'edituser' => "Редактирование профиля",
    'profile' => "Просмотр профиля",
    'confirm' => "Подтверждение удаления",
    'addpage' => "Добавление страницы",
    'editpage' => "Редактирование страницы",
    'editnews' => "Редактирование новости",
    'addnews' => "Добавление новости",
    'recycle' => "Корзина",
    'find' => "Поиск",
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="images/icons/B.png" type="image/x-icon">
    <?= $viteAssets->css('css/main.css') ?>
    <?= $viteAssets->css('css/admin.css') ?>
    <?= $viteAssets->css('scss/styles.scss') ?>

    <script type="module" src="<?= htmlspecialchars($viteAssets->asset('js/main.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
</head>
<body class="bg-light text-dark d-flex flex-column min-vh-100">

<?php
if (empty($user)): ?>
    <div class="container py-5 text-center">
        <h1 class="display-4">bCMS</h1>
    </div>
<?php
else: ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">bCMS</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Уменьшенные отступы mx-2 и сдвиг меню ms-4 -->
                <ul class="navbar-nav ms-5 me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-2"><a class="nav-link <?= $c === 'page' ? 'active' : '' ?>"
                                                 href="index.php?c=page">Страницы</a></li>
                    <li class="nav-item mx-2"><a class="nav-link <?= $c === 'news' ? 'active' : '' ?>"
                                                 href="index.php?c=news">Новости</a></li>
                    <?php
                    if (!empty($settings['m_users'])): ?>
                        <li class="nav-item mx-2"><a class="nav-link <?= $c === 'users' ? 'active' : '' ?>"
                                                     href="index.php?c=users">Пользователи</a></li>
                    <?php
                    endif; ?>
                    <li class="nav-item mx-2"><a class="nav-link <?= $c === 'modules' ? 'active' : '' ?>"
                                                 href="index.php?c=modules">Модули</a></li>
                    <li class="nav-item mx-2"><a class="nav-link <?= $c === 'review' ? 'active' : '' ?>"
                                                 href="index.php?c=review">Отзывы</a></li>
                </ul>

                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-3">
                        <a href="/" class="nav-link text-white" title="На сайт" aria-label="На сайт">
                            <!-- SVG вставляется прямо сюда -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#999999" viewBox="0 0 24 24" width="24"
                                 height="24">
                                <path d="M3 9.75L12 3l9 6.75V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.75z"/>
                            </svg>
                        </a>
                    </li>

                    <li class="nav-item me-3">
                        <a href="index.php?c=recycle" class="nav-link position-relative text-white" title="Корзина">
                            <img src="images/icons/recycle_head.png" width="24" height="24" alt="Корзина">
                            <?php
                            if (!empty($recyclecount)): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">
                                <?= $recyclecount ?>
                            </span>
                            <?php
                            endif; ?>
                        </a>
                    </li>

                    <li class="nav-item me-3">
                        <a href="index.php?c=settings" class="nav-link text-white" title="Настройки">
                            <img src="images/icons/settings.png" width="24" height="24" alt="Настройки">
                        </a>
                    </li>

                    <li class="nav-item d-flex align-items-center px-3 text-white">|</li>

                    <li class="nav-item mx-2">
                        <a href="index.php?c=auth&exit" class="nav-link text-white">Выход</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    if (isset($subNav[$c])): ?>
        <div class="bg-light border-bottom py-2 px-3 small text-muted">
            » <?= htmlspecialchars($subNav[$c]) ?>
        </div>
    <?php
    endif; ?>

<?php
endif; ?>

<?php
if (empty($user)): ?>
    <div class="container d-flex flex-column justify-content-center align-items-center flex-grow-1"
         style="min-height: 30vh;">
        <?= $content ?>
    </div>
<?php
else: ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- навигация -->
    </nav>

    <main class="container py-4 flex-grow-1">
        <?= $content ?>
    </main>
<?php
endif; ?>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div>© <?= date('Y') ?> bCMS — Bazhenov Ivan</div>
</footer>

</body>
</html>