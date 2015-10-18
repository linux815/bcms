<?php
/**
 * v_mainsecond.php - вторичный базовый шаблон (используется в основном для модулей)
 * ================
 * $title - содержит заголовок страницы 
 * $content - содержание страницы 
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

    <title><?= $title ?></title>

    <link rel="stylesheet" href="stylesheets/960.css" type="text/css" media="screen" charset="utf-8" />
    <link rel="stylesheet" href="stylesheets/template.css" type="text/css" media="screen" charset="utf-8" />
    <link rel="stylesheet" href="stylesheets/colour.css" type="text/css" media="screen" charset="utf-8" />

    <script type="text/javascript" charset="utf-8" src="javascripts/jquery-1.3.min.js"></script>
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
    <script type="text/javascript">
        $(function () {
            $("#content .grid_5, #content .grid_6").sortable({
                placeholder: 'ui-state-highlight',
                forcePlaceholderSize: true,
                connectWith: '#content .grid_6, #content .grid_5',
                handle: 'h2',
                revert: true
            });
            $("#content .grid_5, #content .grid_6").disableSelection();
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
  </head>
  <body>	
      <?= $content ?>
  </body>
</html>