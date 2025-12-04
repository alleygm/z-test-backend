#!/bin/bash
set -e

# Выполняем миграции (если БД ещё не поднялась — Doctrine сам повторит попытку)
php bin/console doctrine:migrations:migrate --no-interaction || true

# Первичная инициализация данных (один раз)
if [ ! -f "/var/www/z-test-yugrin/.import_done" ]; then
    if [ -f "/var/www/z-test-yugrin/test_task_data.csv" ]; then
        echo "Running tender init command..."
        php bin/console app:user:create-test || true
        php bin/console app:tenders:init || true
        echo "done" > /var/www/z-test-yugrin/.import_done
    fi
fi

exec "$@"
