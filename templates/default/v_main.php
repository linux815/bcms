<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="keywords" content="<?= htmlspecialchars($settings['keywords']) ?>"/>
    <meta name="description" content="<?= htmlspecialchars($settings['description']) ?>"/>
    <link rel="shortcut icon" href="templates/<?= htmlspecialchars($settings['template']) ?>/img/main_logo.ico"
          type="image/x-icon"/>

    <?= $viteAssets->css('css/main.css') ?>

    <script type="module" src="<?= htmlspecialchars($viteAssets->asset('js/main.js'), ENT_QUOTES, 'UTF-8') ?>"></script>

    <!-- Пользовательский CSS -->
    <?= $viteAssets->css('css/custom.css') ?>
</head>
<body>

<div class="main-wrapper">

    <!-- Навигация -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
        <div class="container justify-content-center">
            <div class="collapse navbar-collapse justify-content-between">
                <ul class="navbar-nav mx-auto">
                    <?php
                    $currentId = $_GET['id'] ?? 1;
                    foreach ($pages as $id => $value) {
                        $idPage = $value['id_page'];
                        if ($idPage > 4) {
                            break;
                        }
                        $title = $value['title'];
                        $active = ($currentId == $idPage) ? 'active' : '';
                        echo "<li class='nav-item'><a class='nav-link $active' href='index.php?c=view&id=$idPage'>$title</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Логотип -->
    <div class="logo">
        <img src="assets/img/logo.png" alt="Логотип сайта"/>
    </div>

    <!-- Контент и меню сайта -->
    <div class="container px-4">
        <div class="row">
            <?php
            // Исключаем страницы, если соответствующие модули выключены
            $excludePageIds = [];
            if (empty($settings['news'])) {
                $excludePageIds[] = 2; // Новости
            }
            if (empty($settings['ghost'])) {
                $excludePageIds[] = 3; // Гостевая книга
            }
            if (empty($settings['review'])) {
                $excludePageIds[] = 4; // Обратная связь
            }

            $filteredPages = array_filter($pages, function ($page) use ($excludePageIds) {
                return !in_array((int)$page['id_page'], $excludePageIds, true);
            });
            ?>

            <!-- Меню сайта -->
            <aside class="col-md-3 mb-4">
                <div class="sidebar-menu">
                    <h5 class="mb-3">📂 Меню сайта</h5>
                    <ul class="list-unstyled mb-0">
                        <?php
                        foreach ($filteredPages as $page):
                            $active = ($currentId == $page['id_page']) ? 'active' : '';
                            ?>
                            <li>
                                <a class="<?= $active ?>"
                                   href="index.php?c=view&id=<?= htmlspecialchars($page['id_page']) ?>">
                                    <?= htmlspecialchars($page['title']) ?>
                                </a>
                            </li>
                        <?php
                        endforeach; ?>
                    </ul>
                </div>
            </aside>

            <!-- Основной контент -->
            <main class="col-md-9">
                <div class="content-box">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php?c=view&id=1">Главная</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars(
                                    $temp['title'],
                                ) ?></li>
                        </ol>
                    </nav>

                    <?php
                    if ($currentId != 1): ?>
                        <p class="text-end mb-3">
                            <a href="#" onclick="history.back(); return false;">Вернуться</a>
                        </p>
                    <?php
                    endif; ?>

                    <div id="content"><?= $content ?></div>
                </div>
            </main>
        </div>
    </div>

    <!-- Футер -->
    <footer>
        <p>
            <?php
            if (!empty($settings['ghost'])): ?>
                📬 <a href="index.php?c=view&id=3">Гостевая</a> &nbsp;|&nbsp;
            <?php
            endif; ?>
            ❓ <a href="#" onclick="alert('Вопросы отсутствуют.'); return false;">FAQ</a> &nbsp;|&nbsp;
            <?php
            if (!empty($settings['review'])): ?>
                ✉️ <a href="index.php?c=view&id=4">Обратная связь</a> &nbsp;|&nbsp;
            <?php
            endif; ?>
            <?php
            if (!empty($settings['news'])): ?>
                📰 <a href="index.php?c=view&id=2">Новости</a> &nbsp;|&nbsp;
            <?php
            endif; ?>
            🔐 <a href="/bcms/index.php">Админка</a>
        </p>
        <p>© <?= date('Y') ?> bCMS · E-mail: <a href="mailto:ivan.bazhenov@gmail.com">ivan.bazhenov@gmail.com</a></p>
    </footer>
</div>

<!-- Кнопка наверх -->
<div class="scrollup" onclick="window.scrollTo({top: 0, behavior: 'smooth'});" title="Наверх" role="button"
     aria-label="Наверх"></div>
</body>
</html>