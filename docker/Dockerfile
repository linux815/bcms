# Базовый образ FrankenPHP
FROM dunglas/frankenphp

# Установка рабочей директории
WORKDIR /app

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка системных зависимостей и pdo_mysql
RUN apt-get update && \
    apt-get install -y unzip git zip libpng-dev libonig-dev libxml2-dev libzip-dev mariadb-client && \
    docker-php-ext-install pdo pdo_mysql

# Копируем проект (если нужно)
# COPY . .

# Опционально: установка зависимостей PHP через Composer
# RUN composer install --no-dev --optimize-autoloader

# Установка прав, если требуется
# RUN chown -R www-data:www-data /app

# Открываем нужный порт (если не по умолчанию 80)
# EXPOSE 80