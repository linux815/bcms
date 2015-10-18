<?php
/**
 * v_settings.php - шаблон страницы настроек MaxiCMS
 * ================
 *  $mUsers - отвечает за отображения пункта меню пользователи (0 выключен, 1 включен)
 *  $mdGhost - модуль гостевая книга(0 выключен, 1 включен)
 *  $mdReview - модуль обратная связь: 
  Значения, которые может принять переменная:
  email - отправка на email, который указан в настройках MaxiCMS
  admin - отправка отзывов в администраторский раздел
 */
?>
<style type="text/css">
  .tooltip {
      border-bottom: 1px dotted #000000; color: #000000; outline: none;
      cursor: help; text-decoration: none;
      position: relative;
  }
  .tooltip span {
      margin-left: -999em;
      position: absolute;
  }
  .tooltip:hover span {
      border-radius: 5px 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;
      box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); -moz-box-shadow: 5px 5px rgba(0, 0, 0, 0.1);
      font-family: Calibri, Tahoma, Geneva, sans-serif;
      position: absolute; left: 1em; top: 2em; z-index: 99;
      margin-left: 0; width: 250px;
  }
  .tooltip:hover img {
      border: 0; margin: -10px 0 0 -55px;
      float: left; position: absolute;
  }
  .tooltip:hover em {
      font-family: Candara, Tahoma, Geneva, sans-serif; font-size: 1.2em; font-weight: bold;
      display: block; padding: 0.2em 0 0.6em 0;
  }
  .classic { padding: 0.8em 1em; }
  .custom { padding: 0.5em 0.8em 0.8em 2em; }
  * html a:hover { background: transparent; }
  .classic {background: #e2f3f9; border: 1px solid #FFAD33; }
  .critical { background: #FFCCAA; border: 1px solid #FF3334;	}
  .help { background: #e2f3f9; border: 1px solid #2BB0D7;	}
  .info { background: #9FDAEE; border: 1px solid #2BB0D7;	}
  .warning { background: #FFFFAA; border: 1px solid #FFAD33; }
</style>
<h1>Настройки</h1>
<form method="post" action="#">
  <p>
    <label for="namesite">Название сайта</label>
    <input type="input" id="namesite" name="namesite" size="40" value="<?php echo $nameSite; ?>">
  </p>
  <p>
    <label for="template" style="float: left;">Имя шаблона</label> &nbsp;
    <a class="tooltip" href="#">помощь<span class="custom help"><img src="images/icons/Help.png" alt="Помощь" height="48" width="48" /><em>Знаете ли вы что?</em>По умолчанию доступны шаблоны: default</span></a>
  </p>
  <p>
    <input type="input" id="template" name="template" size="40" value="<?php echo $template; ?>">
  </p>
    <input type="checkbox" name="menu" value="users" <?php if ($m_users == 1): ?> checked <?php endif; ?>>Отображать пункт меню "Пользователи"
    <br/>
  </p>
  <p>
    <b>Модуль "Обратная связь"</b>
  </p>
  <p>
    <input type="radio" name="review" value="email" <?php if ($md_review == "email"): ?> checked <?php endif; ?>>Отправлять данные на Ваш email
    <br/>
    <input type="radio" name="review" value="admin" <?php if ($md_review == "admin"): ?> checked <?php endif; ?>>Отправлять данные в администраторский раздел
    <br/>
  </p>
  <p>
    <b>SEO</b>
  </p>
  <p>
    <label for="keywords" style="float: left;">Ключевые слова</label> &nbsp;
    <a class="tooltip" href="#">помощь<span class="custom help"><img src="images/icons/Help.png" alt="Помощь" height="48" width="48" /><em>Знаете ли вы что?</em>Ключевые слова нужно вводить через запятые, либо через пробелы. <br> Пример: еда, горох, хлеб</span></a>
  </p>
  <p>
    <input type="input" id="keywords" name="keywords" size="40" value="<?php echo $keywords; ?>">
  </p>
  <p>
    <label for="description">Краткое описание сайта</label>
    <input type="input" id="namesite" name="description" size="40" value="<?php echo $description; ?>">
  </p>
  <p>
  <p>
    <input type="submit" value="Сохранить" name="save">
  </p>
  <hr/>
  <p>
    Полная версия bcms: <?php echo $version; ?>
  </p>
</form>