-- Создать базу, если не существует
CREATE DATABASE IF NOT EXISTS bcms CHARACTER SET utf8 COLLATE utf8_general_ci;
USE bcms;

-- Таблица новостей
CREATE TABLE IF NOT EXISTS news
(
    id_news  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title    VARCHAR(255) NOT NULL,
    text     TEXT         NOT NULL,
    date     DATETIME     NOT NULL,
    `delete` TINYINT(1)   NOT NULL DEFAULT 0,
    PRIMARY KEY (id_news)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO news (title, text, date, `delete`)
VALUES ('Первая новость',
        '<p style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;Это первая тестовая новость. Для того чтобы отключить данный модуль со страницы, перейдите в администраторский раздел, в пункте страницы нажмите редактировать страницу "Новости" и в выпадающем списке "Подключить модули" выберите пункт "Отключить все модули от данной страницы" и нажмите кнопку "Добавить".</p>
         <p style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;Если необходимо отключить данный модуль со всех страниц, то перейдите в раздел "Подключение модулей" и в разделе "Новости" нажмите на ссылку "Выключить".</p>',
        '2015-08-15 19:32:48',
        0);

-- Таблица гостевой книги
CREATE TABLE IF NOT EXISTS ghost
(
    id      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title   VARCHAR(255) NOT NULL,
    email   VARCHAR(255) NOT NULL,
    url     VARCHAR(255) NOT NULL,
    message TEXT         NOT NULL,
    date    DATETIME     NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- Таблица сессий
CREATE TABLE IF NOT EXISTS sessions
(
    id_session INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_user    INT UNSIGNED NOT NULL,
    sid        VARCHAR(255) NOT NULL,
    time_start DATETIME     NOT NULL,
    time_last  DATETIME     NOT NULL,
    PRIMARY KEY (id_session),
    UNIQUE KEY sid_unique (sid)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users
(
    id_user      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    login        VARCHAR(255) NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL,
    id_role      INT          NOT NULL DEFAULT 3,
    name         VARCHAR(255) NOT NULL DEFAULT 'Пользователь',
    surname      VARCHAR(255) NOT NULL DEFAULT '',
    avatar       VARCHAR(255) NOT NULL DEFAULT '../bcms/images/avatar.png',
    notice       TINYINT(1)   NOT NULL DEFAULT 0,
    `delete`     TINYINT(1)   NOT NULL DEFAULT 0,
    email        VARCHAR(255) NOT NULL DEFAULT '',
    lastname     VARCHAR(255) NOT NULL DEFAULT '',
    reg_date     DATE         NOT NULL,
    birth_date   DATE         NOT NULL,
    sex          VARCHAR(255) NOT NULL DEFAULT 'Не определен',
    view         INT UNSIGNED NOT NULL DEFAULT 0,
    city         VARCHAR(255) NOT NULL DEFAULT '',
    mobile_phone VARCHAR(255) NOT NULL DEFAULT '',
    work_phone   VARCHAR(255) NOT NULL DEFAULT '',
    skype        VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY (id_user)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO users (login, password, id_role, name, avatar, notice, `delete`, reg_date, birth_date, sex, view,
                   work_phone, skype)
VALUES ('bcms', '5ebe2294ecd0e0f08eab7690d2a6ee69', 1, 'Admin', '../bcms/images/avatar.png', 0, 0, '2015-08-01',
        '2016-01-01', 'Не определен', 0, '', '');

-- Таблица настроек
CREATE TABLE IF NOT EXISTS settings
(
    id_settings INT UNSIGNED NOT NULL AUTO_INCREMENT,
    template    VARCHAR(255) NOT NULL DEFAULT 'default',
    namesite    VARCHAR(255) NOT NULL DEFAULT 'Мой первый сайт',
    news        TINYINT(1)   NOT NULL DEFAULT 1,
    ghost       TINYINT(1)   NOT NULL DEFAULT 1,
    review      TINYINT(1)   NOT NULL DEFAULT 1,
    m_users     TINYINT(1)   NOT NULL DEFAULT 0,
    md_review   VARCHAR(255) NOT NULL DEFAULT 'admin',
    email       VARCHAR(255) NOT NULL,
    keywords    TEXT         NOT NULL,
    description TEXT         NOT NULL,
    PRIMARY KEY (id_settings)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO settings (template, namesite, news, ghost, review, m_users, md_review, email, keywords, description)
VALUES ('default', 'Мой первый сайт', 1, 1, 1, 0, 'admin', '', '', '');

-- Таблица отзывов
CREATE TABLE IF NOT EXISTS reviews
(
    id_review INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title     VARCHAR(255) NOT NULL,
    text      TEXT         NOT NULL,
    name      VARCHAR(255) NOT NULL,
    email     VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_review)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- Таблица страниц
CREATE TABLE IF NOT EXISTS page
(
    id_page  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title    VARCHAR(255) NOT NULL DEFAULT 'Новая страница',
    text     TEXT         NOT NULL,
    date     DATE         NOT NULL,
    html     TINYINT(1)   NOT NULL DEFAULT 0,
    `delete` TINYINT(1)   NOT NULL DEFAULT 0,
    news     TINYINT(1)   NOT NULL DEFAULT 0,
    ghost    TINYINT(1)   NOT NULL DEFAULT 0,
    review   TINYINT(1)   NOT NULL DEFAULT 0,
    hide     TINYINT(1)   NOT NULL DEFAULT 0,
    PRIMARY KEY (id_page)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO page (title, text, date, html, `delete`, news, ghost, review, hide)
VALUES ('Главная страница', '<h1><strong>Тестовый сайт</strong></h1>', '2015-08-15', 0, 0, 0, 0, 0, 0),
       ('Новости', '', '2015-08-15', 0, 0, 1, 0, 0, 0),
       ('Гостевая книга',
        '<p><a class="tooltip" href="#">Наведите для помощи<span class="custom help"><em>Знаете ли вы что?</em>Чтобы заработала capchta от Google, нужно отредактировать файл v_ghost.php, которой расположен по пути: templates/default/v_ghost.php и отредактировать переменную sitekey и secret, которые выдает Google. - 42 строка</span></a></p>',
        '2015-08-15', 0, 0, 0, 1, 0, 0),
       ('Обратная связь',
        '<p><a class="tooltip" href="#">Наведите для помощи<span class="custom help"><em>Знаете ли вы что?</em>Чтобы заработала capchta от Google, нужно отредактировать файл v_review.php, которой расположен по пути: templates/default/v_review.php и отредактировать переменную sitekey и secret, которые выдает Google. - 28 строка</span></a></p>',
        '2015-08-15', 0, 0, 0, 0, 1, 0);