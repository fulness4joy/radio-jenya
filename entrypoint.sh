#!/bin/bash

set -e

# echo "Waiting for database..."

# until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1" >/dev/null 2>&1
# do
#     sleep 2
# done

# echo "Database connected."

# php artisan key:generate --force

# Для применения миграций при обычном развертывании контейнера
php artisan migrate --force

# Для пересоздания базы данных и заполнения начальными данными, используйте команду migrate:fresh с опцией --seed. Это удалит все таблицы и создаст их заново, а затем выполнит сидирование базы данных.
#php artisan migrate:fresh --seed --force

php artisan storage:link || true

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground