<?php
/**
 * v_mainsecond.php — вторичный шаблон (чаще для модулей)
 * $title   — заголовок страницы
 * $content — HTML содержимое
 */

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="images/icons/B.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?= $viteAssets->css('css/main.css') ?>
    <?= $viteAssets->css('css/admin.css') ?>
    <?= $viteAssets->css('scss/styles.scss') ?>

    <script type="module" src="<?= htmlspecialchars($viteAssets->asset('js/main.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
</head>
<body>
<?= $content ?>
</body>
</html>