<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title><?= htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>

    <?= $viteAssets->css('css/main.css') ?>

    <script type="module" src="<?= htmlspecialchars($viteAssets->asset('js/main.js'), ENT_QUOTES, 'UTF-8') ?>"></script>

    <!-- Пользовательский CSS -->
    <?= $viteAssets->css('css/custom.css') ?>
</head>
<body>
<?= $content ?>
</body>
</html>