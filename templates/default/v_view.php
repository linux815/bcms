<?php
/**
 * v_view.php — основной шаблон отображения контента страницы
 *
 * Доступные переменные:
 * $content  — массив с текущей страницей (таблица `page`)
 * $settings — массив с настройками (таблица `settings`)
 */

use Classes\Modules\Ghost;
use Classes\Modules\News;
use Classes\Modules\Review;

// Подключение модуля "Новости"
if (!empty($content['news']) && !empty($settings['news'])) {
    (new News())->request();
}

// Подключение модуля "Обратная связь"
if (!empty($content['review']) && !empty($settings['review'])) {
    (new Review())->request();
}

// Подключение модуля "Гостевая книга"
if (!empty($content['ghost']) && !empty($settings['ghost'])) {
    (new Ghost())->request();
}
?>

<!-- Основной текст страницы -->
<div class="page-text">
    <?= $content['text'] ?? '' ?>
</div>