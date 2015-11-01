<?php
/**
 * v_editpage.php - шаблон редактирования страницы
 * ================
 * $page - массив, содержащий текущую страницу.
 * Содержит в себе элементы: 
 * 	id_page - номер страницы
 *  title - заголовок страницы
 *  text - текст страницы, созданный в редакторе TinyMCE
 *  date - дата последнего изменения/создания страницы
 * ================
 * Пример: echo $page['text'] - выводит текст текущей страницы
 */
?>
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        skin: 'light',
        height: 350,
        autosave_interval: "20s",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak autosave",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor responsivefilemanager"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image hr | print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        language: 'ru',
        external_filemanager_path: "filemanager/",
        filemanager_title: "Responsive Filemanager",
        browser_spellcheck: true,
        external_plugins: {"filemanager": "../filemanager/plugin.min.js"}
    });
</script>
<?php if (isset($error)): ?> <p class='error'><?= $error ?></p> <?php else: ?>
    <form method="post" action="somepage">	
      <p>
        <label>Название страницы <small>Данное название добавляется в меню вашего сайта.</small></label>
        <input type="text" name="title" style="width: 99%;" value="<?= $page['title'] ?>"/>
      </p>
      <p>
        <label>Подключить модуль<small>при нажатии на кнопку, данные модули добавляются без перезагрузки страницы.</small></label>
        <select id="module" name="modules">
          <option disabled selected>Выберите модуль для данной страницы</option>
          <option value="news">Подключить модуль "Новости"</option>
          <option value="ghost">Подключить гостевую книгу</option>
          <option value="review">Подключить модуль "Обратная связь"</option>
          <option value="disable">Отключить все модули от данной страницы</option>	
        </select>

        <input type="hidden" id="id" name="hide" value="<?= $_GET['id'] ?>">	

        <script type="text/javascript">
            function send()
            {
                //Получаем параметры
                var module = $('#module').val();
                var id = $('#id').val();
                // Отсылаем паметры
                $.ajax({
                    type: "POST",
                    url: "index.php?c=jquery",
                    data: "module=" + module + "&id=" + id,
                    // Выводим то что вернул PHP
                    success: function (html) {
                        //предварительно очищаем нужный элемент страницы
                        $("#result").empty();
                        //и выводим ответ php скрипта
                        $("#result").append(html);
                    }
                });

            }
            function check()
            {
                //Получаем параметры
                // Отсылаем паметры
                $.ajax({
                    type: "POST",
                    url: "http://bazhenov.esy.es/maxicms/index.php?c=jquery&check",
                    // Выводим то что вернул PHP
                    success: function (html) {
                        //предварительно очищаем нужный элемент страницы
                        $("#check").empty();
                        //и выводим ответ php скрипта
                        $("#check").append(html);
                    }
                });

            }
        </script>

        <a href="#" onclick="send();" >Добавить</a><div id="result"></div>
    </p>	

    <textarea name="content" style="width:100%"><?= $page['text'] ?></textarea>

    <br/>

    <p>
      <button class="button" type="submit" name="SaveInfo" formaction="" formmethod="post" formenctype="multipart/form-data">
        <img src="images/icons/tick.png" alt="Save" name="Save" /> Сохранить
      </button>
    </p>	
    </form>
<?php endif; ?>