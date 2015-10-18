<?php
/**
 * v_addpage - шаблон добавления страницы
 * ================
 * $error - содержит название ошибки. Если ошибки нет, переменная пустая.
 */
?>
<form method="post">
  <div class="grid_16">
    <h2>Добавление новой страницы</h2>

    <?php
    if ($error == ""):
    else:
        ?>

        <p class="error"><?= $error ?></p>

    <?php endif; ?>
  </div>

  <div class="grid_16">
    <p>
      <label>Заголовок <small>Данное название добавляется в меню вашего сайта.</small></label>
      <input type="text" name="title" />
    </p>
  </div>

  <div class="grid_16">
    <p>
      <label class="label" for="hide">Сделать страницу скрытой?</label>					
      <select name="hide" id="hide">
        <option value="1">Да</option>
        <option value="0" selected>Нет</option>
      </select>					
    </p>				
  </div>

  <div class="grid_16">		
    <p>
      <input type="reset" value="Сброс" />
      <input type="submit" value="Добавить" />
    </p>
  </div>
</form>