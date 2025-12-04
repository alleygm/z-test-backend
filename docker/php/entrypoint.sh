#!/bin/bash
set -e

if [ ! -f "/var/www/z-test-yugrin/.import_done" ]; then
    sleep 20
    if [ -f "/var/www/z-test-yugrin/test_task_data.csv" ]; then
        chmod -R 777 /var
        php bin/console doctrine:migrations:migrate --no-interaction || true
        php bin/console app:user:create-test || true
        php bin/console app:tenders:init || true
        echo "done" > /var/www/z-test-yugrin/.import_done
    fi
fi

exec "$@"
