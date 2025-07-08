#!/bin/bash

set -e

echo "=== 🛠  bCMS setup script ==="

# Проверка наличия файла .env
if [ ! -f ".env" ]; then
    echo "⚠️  Файл .env не найден. Копируем .env.example → .env"
    cp .env.example .env
else
    echo "ℹ️  Файл .env уже существует."
fi

# Подтверждение удаления контейнеров и данных
echo "❗️ ВНИМАНИЕ: Все контейнеры, тома и данные текущего проекта будут удалены."
read -p "Вы уверены, что хотите продолжить? (yes/no): " confirm

if [[ "$confirm" != "yes" ]]; then
    echo "❌ Операция отменена."
    exit 1
fi

echo "🧹 Удаляем контейнеры и тома..."
docker compose down --volumes --remove-orphans

echo "📦 Собираем контейнеры (включая Vite)..."
docker compose build

echo "📥 Устанавливаем npm-зависимости..."
docker compose run --rm node npm install

echo "⚙️  Сборка фронтенда (Vite)..."
docker compose run --rm node npm run build

echo "🚀 Запускаем контейнеры..."
docker compose up -d

echo "📥 Устанавливаем зависимости PHP (Composer)..."
docker compose run --rm app composer install

echo ""
echo "✅ Всё готово!"
echo ""
echo "🌐 Перейдите в браузере:"
echo "   📦 Установка: https://localhost/install"
echo ""
echo "🔐 После установки войдите в админку:"
echo "   https://localhost/bcms/index.php"
echo "   Логин: bcms"
echo "   Пароль: secret"