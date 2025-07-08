# bCMS

Система управления контентом **bCMS 4**

Подойдет новичкам, которые изучают язык, студентам и т.д. :)

---

## Установка и запуск

Для разворачивания проекта выполните скрипт:

```bash
./setup.sh

```

---

## Доступ в админ-панель

По умолчанию логин и пароль для входа в админку:

- Логин: `bcms`
- Пароль: `secret`

Админка доступна по адресу:  
[https://localhost/bcms/index.php](https://localhost/bcms/index.php)  
(или соответствующий путь вашего сервера)

---

## Особенности

- Поддержка PHP 8.x
- Использование Bootstrap 5 для интерфейса
- TinyMCE 7.9.1 для редактирования контента
- Статический анализ кода с PHPStan
- Веб-сервер Caddy + FrankenPHP в комплекте
- Математическая капча для защиты форм
- Современная структура и автозагрузка с Composer

---

## Структура проекта

- `bcms/` — основной код CMS
- `bcms/templates/` — шаблоны и стили
- `public/` — публичная директория с точкой входа и публичными ресурсами
- `vendor/` — зависимости Composer
- `setup.sh` — скрипт для разворачивания и настройки проекта

---

## Лицензия

```text
MIT License

Copyright (c) 2025 Ivan Bazhenov

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
```