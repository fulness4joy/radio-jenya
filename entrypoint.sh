#!/bin/bash

set -e

# echo "Waiting for database..."

# until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1" >/dev/null 2>&1
# do
#     sleep 2
# done

# echo "Database connected."

# php artisan key:generate --force

# php artisan migrate --force

# php artisan db:seed --force
php artisan migrate:fresh --seed --force

php artisan storage:link || true

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground