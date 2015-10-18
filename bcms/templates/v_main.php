<?php
/**
 * v_main.php - базовый шаблон
 * ================
 * $title - содержит заголовок страницы 
 * $user[0] - если пользователь авторизован, то $user[0] не пустой
 * $content - содержание страницы 
 * ================
 * $settings - массив настройки MaxiCMS
 * Cодержит в себе элементы:
 *  template - имя шаблона сайта
 *  namesite - название сайта 
 *  news - модуль новости (0 выключен, 1 включен)
 *  ghost - модуль гостевая книга(0 выключен, 1 включен)
 *  review - модуль обратная связь(0 выключен, 1 включен)
 *  md_review - если равен admin, то отправлять отзывы в администраторский раздел сайта
 *  email - электронный ящик администратора
 * ================
 * Пример: echo $settings['news'] - проверяем включен ли модуль новости
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

    <title><?= $title ?></title>

    <link rel="shortcut icon" href="images/icons/B.png" type="image/x-icon"/>	
      <link rel="stylesheet" href="stylesheets/960.css" type="text/css" media="screen" charset="utf-8" />
      <link rel="stylesheet" href="stylesheets/template.css" type="text/css" media="screen" charset="utf-8" />
      <link rel="stylesheet" href="stylesheets/colour.css" type="text/css" media="screen" charset="utf-8" />

      <script type="text/javascript" charset="utf-8" src="javascripts/jquery-1.3.min.js"></script>
      <script type="text/javascript" charset="utf-8" src="javascripts/jquery.localscroll.js"></script>
      <script type="text/javascript" src="javascripts/jquery.maskedinput-1.2.2.js"></script>

      <script type="text/javascript">
          jQuery(function ($) {
              $.mask.definitions['~'] = '[+-]';
              $('#birth_date').mask('99.99.9999');
              $('#mobile_phone').mask('(999) 999-9999');
              $('#phoneext').mask("(999) 999-9999? x99999");
              $("#tin").mask("99-9999999");
              $("#ssn").mask("999-99-9999");
              $("#product").mask("a*-999-a999");
              $("#eyescript").mask("~9.99 ~9.99 999");
          });
      </script>

      <script src="javascripts/1.7.0/core/core.js" type="text/javascript"></script>
      <script src="javascripts/1.7.0/widgets/widgets.js" type="text/javascript"></script>
      <link href="javascripts/1.7.0/widgets/widgets.css" type="text/css" rel="stylesheet" />

      <script type="text/javascript">
          glow.ready(function () {
              new glow.widgets.Sortable(
                      '#content .grid_5, #content .grid_6',
                      {
                          draggableOptions: {
                              handle: 'h2'
                          }
                      }
              );
          });
      </script>	

      <!--[if IE]><![endif]><![endif]-->

      <script type="text/javascript">
          window.onload = function () {
              var menu = document.getElementById('navigation').getElementsByTagName('a'), i = menu.length;
              while (i--) {
                  menu[i].className = menu[i].href == window.location.href ? 'active' : 'inactive';
              }
          };
      </script>	
      <script language="text/javascript">
          function checkAll(obj) {
              'use strict';
              var items = obj.form.getElementsByTagName("input"),
                      len, i;

              for (i = 0, len = items.length; i < len; i += 1) {
                  if (items.item(i).type && items.item(i).type === "checkbox") {
                      if (obj.checked) {
                          items.item(i).checked = true;
                      } else {
                          items.item(i).checked = false;
                      }
                  }
              }
          }
      </script>
  </head>
  <body>
      <?php if ($user[0] == ""): ?>
        <h1 id="head">bCMS</h1> 
    <?php else: ?>

        <div id="head">
          <h1 style="font-size:25px; border: 0px; margin-bottom:0px;">Администраторский раздел - bCMS</h1>
          <a href="index.php?c=recycle">
            <img src="images/icons/recycle_head.png" width="24px" height="24px" style="position: absolute; margin: -30px 0px 0px 900px; cursor:pointer;" alt="Перейти в корзину" title="Перейти в корзину" />
            <?php if (isset($recyclecount) and $recyclecount > 0): ?>
                <div class="badge badge-important"><?= $recyclecount ?></div>
            <?php endif; ?>
          </a>
          <a href="index.php?c=settings">
            <img src="images/icons/settings.png" width="24px" height="24px" style="position: absolute; margin: -30px 0px 0px 930px; cursor:pointer;" alt="Перейти в настройки bCMS" title="Перейти в настройки bCMS" />
          </a>
        </div>
        <ul id="navigation">
          <li><a href="index.php">Главная</a></li>
          <li><a href="index.php?c=page">Страницы</a></li>
          <li><a href="index.php?c=news">Новости</a></li>

          <?php if ($settings['m_users'] == 1): ?>
              <li><a href="index.php?c=users">Пользователи</a></li>
          <?php endif; ?>
          <li><a href="index.php?c=modules">Подключение модулей</a></li>
          <li>|</li>
          <?php
          if (!isset($_GET['c'])) {
              $c = '';
          } else {
              $c = htmlspecialchars(trim($_GET['c']));
          }

          switch ($c) {
              case 'edituser':
                  echo "<li><a href='index.php?c=edituser&id=" . $_GET['id'] . "'>Редактирование профиля</a></li><li> |</li>";
                  break;
              case 'profile':
                  echo "<li><a href='index.php?c=profile&id=" . $_GET['id'] . "'>Просмотр профиля</a></li><li> |</li>";
                  break;
              case 'confirm':
                  echo "<li><a href='index.php?c=confirm&delete=" . $_GET['delete'] . "&id=" . $_GET['id'] . "'>Подтверждение удаления</a></li><li> |</li>";
                  break;
              case 'addpage':
                  echo "<li><a href='index.php?c=addpage'>Добавление страницы</a></li><li> |</li>";
                  break;
              case 'editpage':
                  echo "<li><a href='index.php?c=editpage&id=" . $_GET['id'] . "'>Редактирование страницы</a></li><li> |</li>";
                  break;
              case 'editnews':
                  echo "<li><a href='index.php?c=editnews&id=" . $_GET['id'] . "'>Редактирование новости</a></li><li> |</li>";
                  break;
              case 'addnews':
                  echo "<li><a href='index.php?c=addnews'>Добавление новости</a></li><li> |</li>";
                  break;
              case 'review':
                  echo "<li><a href='index.php?c=review'>Обратная связь</a></li><li> |</li>";
                  break;
              case 'recycle':
                  echo "<li><a href='index.php?c=recycle&delete=" . $_GET['delete'] . "'>Корзина</a></li><li> |</li>";
                  break;
              case 'settings':
                  echo "<li><a href='index.php?c=settings'>Настройки bCMS</a></li><li> |</li>";
                  break;
              case 'find':
                  echo "<li><a href='#'>Поиск</a></li><li> |</li>";
                  break;
              default:
                  echo "";
          }
          ?>
          <li><a href="index.php?c=auth&exit">Выход</a></li>			
        </ul>

    <?php endif; ?>

    <div id="content" class="container_16 clearfix">
        <?= $content ?>
    </div>		

    <div id="foot">
      <i>© 2015 «bCMS» Баженов Иван</a>
    </div>	
  </body>
</html>