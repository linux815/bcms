<?php

if (isset($_POST['submit'])) {
    try {
        $dbh = new PDO(
            "mysql:host=" . $_POST['localhost'] . ";",
            $_POST['user'],
            $_POST['password'],
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
        );

        $sql = "CREATE DATABASE IF NOT EXISTS " . $_POST['db'] . " CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS `" . $_POST['db'] . "`.`news` ( `id_news` INT(255) NOT NULL AUTO_INCREMENT , `title` VARCHAR(255) NOT NULL , `text` TEXT NOT NULL , `date` DATETIME NOT NULL , `delete` VARCHAR(2) NOT NULL DEFAULT '0' , PRIMARY KEY (`id_news`)) ENGINE = InnoDB;

INSERT INTO `" . $_POST['db'] . "`.`news` (`id_news`, `title`, `text`, `date`, `delete`) VALUES (NULL, 'Первая новость', "
            . "'<p style=\"text-align: left;\">&nbsp;&nbsp;&nbsp;&nbsp;Это первая тестовая новость. Для того чтобы отключить данный модуль со страницы, перейдите в администраторский раздел, в пункте страницы нажмите редактировать страницу \"Новости\" и в выпадающем списке \"Подключить модули\" выберите пункт \"Отключить все модули от данной страницы\" и нажмите кнопку \"Добавить\".</p>
<p style=\"text-align: left;\">&nbsp;&nbsp;&nbsp;&nbsp;Если необходимо отключить данный модуль со всех страниц, то перейдите в раздел \"Подключение модулей\" и в разделе \"Новости\" нажмите на ссылку \"Выключить\".</p>', '2015-08-15 19:32:48', '0');

CREATE TABLE IF NOT EXISTS `" . $_POST['db'] . "`.`ghost` ( `id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `url` VARCHAR(255) NOT NULL , `message` TEXT NOT NULL , `date` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `" . $_POST['db'] . "`.`sessions` ( `id_session` INT(255) NOT NULL AUTO_INCREMENT , `id_user` INT(255) NOT NULL , `sid` VARCHAR(255) NOT NULL , `time_start` DATETIME NOT NULL , `time_last` DATETIME NOT NULL , PRIMARY KEY (`id_session`), UNIQUE `sid` (`sid`(255))) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `" . $_POST['db'] . "`.`users` ( `id_user` INT(255) NOT NULL AUTO_INCREMENT primary key, `login` VARCHAR(255) NOT NULL DEFAULT '' unique key, `password` VARCHAR(255) NOT NULL DEFAULT '', `id_role` INT NOT NULL DEFAULT '3', `name` VARCHAR(255) NOT NULL DEFAULT 'Пользователь', `surname` VARCHAR(255) NOT NULL DEFAULT '', `avatar` VARCHAR(255) NOT NULL DEFAULT '../bcms/images/avatar.png', `notice` INT(1) NOT NULL DEFAULT '0', `delete` INT(1) NOT NULL DEFAULT '0', `email` VARCHAR(255) NOT NULL DEFAULT '', `lastname` VARCHAR(255) NOT NULL DEFAULT '', `reg_date` DATE NOT NULL, `birth_date` DATE NOT NULL, `sex` VARCHAR(255) NOT NULL DEFAULT 'Не определен', `view` INT(255) NOT NULL DEFAULT '0', `city` VARCHAR(255) NOT NULL DEFAULT '', `mobile_phone` VARCHAR(255) NOT NULL DEFAULT '', `work_phone` VARCHAR(255) NOT NULL, `skype` VARCHAR(255) NOT NULL ) ENGINE = InnoDB;

INSERT INTO `" . $_POST['db'] . "`.`users` (`id_user`, `login`, `password`, `id_role`, `name`, `surname`, `avatar`, `notice`, `delete`, `email`, `lastname`, `reg_date`, `birth_date`, `sex`, `view`, `city`, `mobile_phone`, `work_phone`, `skype`) VALUES (NULL, 'bcms', '538a474d9c0ba7482348abac6d0b80a8', '1', 'Admin', '', '../bcms/images/avatar.png', '0', '0', '', '', '2015-08-01', '2016-01-01', 'Не определен', '0', '', '', '', '');

CREATE TABLE `" . $_POST['db'] . "`.`settings` ( `id_settings` INT(255) NOT NULL AUTO_INCREMENT , `template` VARCHAR(255) NOT NULL DEFAULT 'default' , `namesite` VARCHAR(255) NOT NULL DEFAULT 'Мой первый сайт' , `news` INT(1) NOT NULL DEFAULT '1' , `ghost` INT(1) NOT NULL DEFAULT '1' , `review` INT(1) NOT NULL DEFAULT '1' , `m_users` INT(1) NOT NULL DEFAULT '0' , `md_review` VARCHAR(255) NOT NULL DEFAULT 'admin' , `email` VARCHAR(255) NOT NULL , PRIMARY KEY (`id_settings`)) ENGINE = InnoDB;

ALTER TABLE `" . $_POST['db'] . "`.`settings` ADD `keywords` TEXT NOT NULL ,
ADD `description` TEXT NOT NULL ;

INSERT INTO `" . $_POST['db'] . "`.`settings` (`id_settings`, `template`, `namesite`, `news`, `ghost`, `review`, `m_users`, `md_review`, `email`, `keywords`, `description`) VALUES (NULL, 'default', '" . $_POST['namesite'] . "', '1', '1', '1', '0', 'admin', '" . $_POST['email'] . "', '', '');

CREATE TABLE `" . $_POST['db'] . "`.`reviews` ( `id_review` INT(255) NOT NULL AUTO_INCREMENT , `title` VARCHAR(255) NOT NULL , `text` TEXT NOT NULL , `name` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , PRIMARY KEY (`id_review`)) ENGINE = InnoDB;

CREATE TABLE `" . $_POST['db'] . "`.`page` ( `id_page` INT(255) NOT NULL AUTO_INCREMENT , `title` VARCHAR(255) NOT NULL DEFAULT 'Новая страница' , `text` TEXT NOT NULL , `date` DATE NOT NULL , `html` INT(1) NOT NULL DEFAULT '0' , `delete` INT(1) NOT NULL DEFAULT '0' , `news` INT(1) NOT NULL DEFAULT '0' , `ghost` INT(1) NOT NULL DEFAULT '0' , `review` INT(1) NOT NULL DEFAULT '0' , `hide` INT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id_page`)) ENGINE = InnoDB;

INSERT INTO `" . $_POST['db'] . "`.`page` (`id_page`, `title`, `text`, `date`, `html`, `delete`, `news`, `ghost`, `review`, `hide`) VALUES (NULL, 'Главная страница', '<h1><strong>Тестовый сайт</strong></h1>', '2015-08-15', '0', '0', '0', '0', '0', '0');

INSERT INTO `" . $_POST['db'] . "`.`page` (`id_page`, `title`, `text`, `date`, `html`, `delete`, `news`, `ghost`, `review`, `hide`) VALUES (NULL, 'Новости', '', '2015-08-15', '0', '0', '1', '0', '0', '0');

INSERT INTO `" . $_POST['db'] . "`.`page` (`id_page`, `title`, `text`, `date`, `html`, `delete`, `news`, `ghost`, `review`, `hide`) VALUES (NULL, 'Гостевая книга', '<p><a class=\"tooltip\" href=\"#\">Наведите для помощи<span class=\"custom help\"><em>Знаете ли вы что?</em>Чтобы заработала capchta от Google, нужно отредактировать файл v_ghost.php, которой расположен по пути: templates/default/v_ghost.php и отредактировать переменную sitekey и secret, которые выдает Google. - 42 строка</span></a></p>', '2015-08-15', '0', '0', '0', '1', '0', '0');

INSERT INTO `" . $_POST['db'] . "`.`page` (`id_page`, `title`, `text`, `date`, `html`, `delete`, `news`, `ghost`, `review`, `hide`) VALUES (NULL, 'Обратная связь', '<p><a class=\"tooltip\" href=\"#\">Наведите для помощи<span class=\"custom help\"><em>Знаете ли вы что?</em>Чтобы заработала capchta от Google, нужно отредактировать файл v_review.php, которой расположен по пути: templates/default/v_review.php и отредактировать переменную sitekey и secret, которые выдает Google. - 28 строка</span></a></p>', '2015-08-15', '0', '0', '0', '0', '1', '0');

";

        $q = $dbh->prepare($sql);
        $q->execute();
        $dbh = null;

        $code = '<?php
/*
 * Базовый конфигурационный файл
 */
// База данных
if (!defined("HOSTNAME")) {
	define("HOSTNAME", "' . $_POST['localhost'] . '");
}	
if (!defined("USERNAME")) {
	define("USERNAME", "' . $_POST['user'] . '");
}
if (!defined("PASSWORD")) {
	define("PASSWORD", "' . $_POST['password'] . '");
}
if (!defined("DBNAME")) {
	define("DBNAME", "' . $_POST['db'] . '");
}

// Admin
if (!defined("EMAIL")) {
	define("EMAIL", "' . $_POST['email'] . '");
}';
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/bcms/classes/Config/Config.php', $code);

        echo "<center><h1>bCMS успешно установлена!</h1> <h3><a href='../bcms/index.php'>Перейти в администраторский раздел bCMS</a></h3</center>";
    } catch (PDOException $e) {
        return "База данных временно не доступна!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Установка bCMS 4.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/demo.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <!--[if lt IE 8]>
    <style>
        .af-wrapper {
            display: none;
        }

        .ie-note {
            display: block;
        }
    </style>
    <![endif]-->
</head>
<body>
<div class="container">
    <?php
    if (isset($_POST['submit'])): echo "";
    else:
        ?>
        <header>
            <h1>Установка <span>bCMS</span></h1>
            <p>Заполните все поля.</p>
        </header>

        <section class="af-wrapper">
            <h3>Общие настройки</h3>

            <form class="af-form" id="af-form" novalidate method="post">

                <div class="af-outer">
                    <div class="af-inner">
                        <label for="input-localhost">Хост</label>
                        <input type="text" name="localhost" id="input-localhost">
                    </div>
                </div>

                <div class="af-outer af-required">
                    <div class="af-inner">
                        <label for="input-user">Пользователь</label>
                        <input type="text" name="user" id="input-user" required>
                    </div>
                </div>

                <div class="af-outer af-required">
                    <div class="af-inner">
                        <label for="input-password">Пароль</label>
                        <input type="password" name="password" id="input-password" required>
                    </div>
                </div>

                <div class="af-outer">
                    <div class="af-inner">
                        <label for="input-db">Имя базы данных</label>
                        <input type="text" name="db" id="input-db" placeholder="">
                    </div>
                </div>

                <div class="af-outer af-required">
                    <div class="af-inner">
                        <label for="input-email">Email</label>
                        <input type="email" name="email" id="input-email" required>
                    </div>
                </div>

                <h3>Дополнительные настройки</h3>

                <div class="af-outer">
                    <div class="af-inner">
                        <label for="input-namesite">Название сайта</label>
                        <input type="text" name="namesite" id="input-namesite">
                    </div>
                </div>

                <input type="submit" value="Установить" name="submit"/>
            </form>
        </section>
    <?php
    endif;
    ?>
</div>
</body>
</html>