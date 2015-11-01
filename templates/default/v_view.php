<?php 
/**
 * v_view.php - основной шаблон
 * ================
 *  $content - массив, содержащий текущую страницу (таблица page)
 *  Содержит: 
 *  id_page - номер страницы
 *  title - заголовок страницы
 *  text - текст страницы, созданный в редакторе TinyMCE
 *  date - дата последнего изменения/создания страницы
 *	review - модуль обратная связь (0 выключен, 1 включен)
 *  news - модуль новости (0 выключен, 1 включен)
 *  ghost - модуль гостевая книга (0 выключен, 1 включен)
 *  ================
 *  $settings - массив, содержащий загруженную таблицу settings
 *  Содержит:
 *	review - модуль обратная связь (0 выключен, 1 включен)
 *  news - модуль новости (0 выключен, 1 включен)
 *  ghost - модуль гостевая книга (0 выключен, 1 включен)
 */
use \classes\Modules\News;
use \classes\Modules\Ghost;
use \classes\Modules\Review;

// Если на текущей странице поле news равняется 1, то загружаем модуль "Новости"
if ($content['news'] == 1 and $settings['news'] == 1) {
	$controller = new News();
	$controller->Request();
}

// Если на текущей странице поле review равняется 1, то загружаем модуль "Обратная связь"
if ($content['review'] == 1 and $settings['review'] == 1) {
	$controller = new Review();
	$controller->Request();
}

// Если на текущей странице поле ghost равняется 1, то загружаем модуль "Гостевая книга"
if ($content['ghost'] == 1 and $settings['ghost'] == 1) {
	$controller = new Ghost();
	$controller->Request();
}
?>
<p>
  <?php echo $content['text']?> <!-- Выводим страницу -->
</p>