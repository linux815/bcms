<?php
/**
 * v_module.php - шаблон страницы подключение модулей
 * ================
 *  $news - модуль новости (0 выключен, 1 включен)
 *  $ghost - модуль гостевая книга(0 выключен, 1 включен)
 *  $review - модуль обратная связь(0 выключен, 1 включен)
 */
?>
<script type="text/javascript">
    function send()
    {
//Получаем параметры
        var title = $('#title').val();
        var text = $('#text').val();
        // Отсылаем паметры
        $.ajax({
            type: "POST",
            url: "index.php?c=jquery",
            data: "title=" + title + "&text=" + text,
            // Выводим то что вернул PHP
            success: function (html) {
                //предварительно очищаем нужный элемент страницы
                $("#result").empty();
//и выводим ответ php скрипта
                $("#result").append(html);
            }
        });

    }
</script>
<form action="#" method="post" id="myform">
  <div class="grid_6">
    <div class="box">
      <h2>Новости</h2>
      <div class="utils">
        <a href="index.php?c=modules&news"><?php if ($news == 1) echo "Выключить";
else echo "Включить"; ?></a>
      </div>
      <p>
        Модуль "Новости" будет отключен на всех страницах вашего сайта.
      </p>
    </div>
    <div class="box">
      <h2>Гостевая книга</h2>
      <div class="utils">
        <a href="index.php?c=modules&ghost"><?php if ($ghost == 1) echo "Выключить";
else echo "Включить"; ?></a>
      </div>
      <p class="center">Модуль "Гостевая книга" будет отключен на всех страницах вашего сайта.</p>
    </div>
  </div>
  <div class="grid_10">
    <div class="box">
      <h2>Обратная связь</h2>
      <div class="utils">
        <a href="index.php?c=modules&review"><?php if ($review == 1) echo "Выключить";
else echo "Включить"; ?></a>
      </div>
      <p>
        <a href="index.php?c=settings">Настроить</a> отправку сообщений. Присутствует возможность выбора отправки сообщения на email или в администраторский раздел.
      </p>
    </div>
  </div>				
</form>