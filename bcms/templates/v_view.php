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
    function check()
    {
        //Получаем параметры
        // Отсылаем паметры
        $.ajax({
            type: "GET",
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
<form action="#" method="post" id="myform">
  <div class="grid_6">
    <div class="box">
      <h2>Общая информация</h2>
      <div class="utils">
      </div>
      <p>
        <b>Название сайта:</b> <?= $nameSite ?> 
        <br />
        <b>Имя базы данных:</b> <?= $dbName ?> 
      <br /> <hr />
      <img src="images/icons/B.png" width="128px" height="128px" style="float:left; /* Выравнивание по левому краю */
           margin: 0px 7px 7px 0px; /* Отступы вокруг картинки */" alt="Версия 3.0.1.2" title="Версия 3.0.1.2">
      <b>Текущая версия:</b> 3.0.1.2
      <br />
      <b>В разработке:</b> Проект закрыт!
      <br /> <br /> <br /> <br /> <br /> <br />
      </p>
    </div>
  </div>
  <div class="grid_6">
    <div class="box">
      <h2>Сообщить об ошибке</h2>
      <div class="utils">
      </div>
      <div id="result"></div>
      <p>
        <label for="title">Заголовок <small>Сообщение отправляется анонимно.</small> </label>
        <input type="text" id="title" name="title" />
      </p>
      <p>
        <label for="post">Текст <small>Мнения, пожелания и замечания.</small> </label>
        <textarea name="post" id="text"></textarea>
      </p>
      <p align="center">
        <input type="button" style="margin-left: 5px;" onclick="send();" value="Отправить" />
      </p>
    </div>
  </div>	
  <div class="grid_4">		
    <div class="box">
      <h2>С чего начать?</h2>
      <div class="utils">
      </div>
      <p>
        <a href="index.php?c=addpage"><img src="images/icons/add-file.png" width="18px" height="18px" style="float:left; /* Выравнивание по левому краю */
                                           margin: 0px 7px 7px 0px; /* Отступы вокруг картинки */">Создать страницу</a>
      </p>
      <p>
        <a href="index.php?c=addnews"><img src="images/icons/edit-file.png" width="18px" height="18px" style="float:left; /* Выравнивание по левому краю */
                                           margin: 0px 7px 7px 0px; /* Отступы вокруг картинки */">Добавить новость</a>
      </p>
      <p>
        <a href="index.php?c=modules"><img src="images/icons/application_edit.png" width="18px" height="18px" style="float:left; /* Выравнивание по левому краю */
                                           margin: 0px 7px 7px 0px; /* Отступы вокруг картинки */">Подключить модули</a>
      </p>
      <p>
        <a href="index.php?c=recycle"><img src="images/icons/recycle.png" width="18px" height="18px" style="float:left; /* Выравнивание по левому краю */
                                           margin: 0px 7px 7px 0px; /* Отступы вокруг картинки */">Перейти в корзину</a>
      </p>
      <p>
        <a href="index.php?c=review"><img src="images/icons/file-find.png" width="18px" height="18px" style="float:left; /* Выравнивание по левому краю */
                                          margin: 0px 7px 7px 0px; /* Отступы вокруг картинки */">Прочитать отзывы о вашем сайте</a>
      </p>
    </div>				
  </div>
</div> <!-- -->
</form>