<?php
/**
 * v_main.php - основной шаблон
 * ================
 *  $content - массив, содержащий текущую страницу (таблица page)
 *  Содержит: 
 *  id_page - номер страницы
 *  title - заголовок страницы
 *  text - текст страницы, созданный в редакторе TinyMCE
 *  date - дата последнего изменения/создания страницы
 * 	review - модуль обратная связь (0 выключен, 1 включен)
 *  news - модуль новости (0 выключен, 1 включен)
 *  ghost - модуль гостевая книга (0 выключен, 1 включен)
 *  ================
 *  $settings - массив, содержащий загруженную таблицу settings
 *  Содержит:
 * 	review - модуль обратная связь (0 выключен, 1 включен)
 *  news - модуль новости (0 выключен, 1 включен)
 *  ghost - модуль гостевая книга (0 выключен, 1 включен)
 */
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="templates/default/img/main_logo.ico" type="image/x-icon">
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <title><?= $title ?></title>
    <meta name="keywords" content="<?= $settings['keywords'] ?>" />
    <meta name="description" content="<?= $settings['description'] ?>" />
    <link href="templates/<?= $settings['template'] ?>/css/style.css" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.scrollup').fadeIn();
                } else {
                    $('.scrollup').fadeOut();
                }
            });
            $('.scrollup').click(function () {
                $("html, body").animate({scrollTop: 0}, 600);
                return false;
            });
        });
    </script>
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
          border: 0; margin: -20px 0 0 -160px;
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
  </head>
  <body>
    <div class="wrapper">
      <div class="box effect8">
        <header class="header">
          <div class="headNav">
            <a href="index.php?c=view&id=1">главная</a>
            <a href="index.php?c=view&id=2">новости</a>
            <a href="index.php?c=view&id=3">гостевая книга</a>
            <a href="index.php?c=view&id=4">обратная связь</a>
            <a class="tooltip" href="#">Наведите для помощи<span class="custom help"><img src="templates/<?php echo $settings['template']?>/img/help.png" alt="Помощь" height="48" width="48" /><em>Знаете ли вы что?</em>Чтобы отредактировать данные ссылки, нужно отредактировать файл v_main.php, которой расположен по пути: templates/default/v_main.php - 89 строка. LOGO редактируется в css-файле</span></a>
          </div><!-- #headNav-->	

          <div class="logo"></div><!-- .logo -->		
        </header><!-- .header-->

        <div class="middle">
          <div class="container">
            <main class="content">
              <h1 class="boxTitle"><?= $temp['title'] ?></h1>	
              <?php if ($_GET['id'] == 1): echo "";
              else: ?>
                  <p align="right" style="margin-right: 10px;"><a href="#" onclick='history.back();
                              return false;'>Вернуться</a></p>
              <?php endif; ?>

              <div id="content">
                <?php echo $content; ?>
              </div> 

            </main><!-- .content -->
          </div><!-- .container-->

          <aside class="left-sidebar">
              <?php
              if ($_GET['id'] > 1):
              ?>
            <?php else: echo "";
            endif; ?>
            <h1 class="boxTitle">Меню сайта</h1>
            <div id="menuDiv">
              <ul class="me"> 
                    <?php foreach ($pages as $page): ?>
                    <li class=m>
                      <a class=m href="index.php?c=view&id=<?= $page['id_page'] ?>">
                      <?= $page['title'] ?>
                      </a>
                    </li>  
            <?php endforeach; ?>
              </ul> 
              <script type="text/javascript" src="templates/<?= $settings['template'] ?>/js/script.js"></script> 
            </div><!-- #menuDiv -->
          </aside><!-- .left-sidebar -->
          <!--
          <aside class="right-sidebar">
            <h1 class="boxTitle">Новости</h1>
          </aside><!-- .right-sidebar -->
        </div><!-- .middle-->

      </div><!-- .wrapper -->

      <footer class="footer">
        <p>
          <a href="index.php?c=view&id=3">Задать вопрос в гостевой</a>
          &nbsp;-&nbsp;
          <a href="" onClick="alert('Вопросы отсутствуют.')">Часто задаваемые вопросы</a>
          &nbsp;-&nbsp;
          <a href="index.php?c=view&id=4">Обратная связь</a>
          &nbsp;-&nbsp;
          <a href="/bcms/index.php">Администраторский раздел</a>
        </p>  
        <p>Copyright © 2015. bCMS.</p>  
        <p>
        E-mail: <a href="mailto: ivan.bazhenov@gmail.com">ivan.bazhenov@gmail.com</a>
        </p>
    </div><!-- .effect8 -->
  </footer><!-- .footer -->
  <a href="#" class="scrollup">Наверх</a>
</body>
</html>