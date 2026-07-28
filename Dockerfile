FROM php:8.4-apache

# Системные зависимости
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    default-mysql-client \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        intl \
        zip \
        gd \
        bcmath \
        opcache

# Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Apache
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

# PHP
RUN composer install --no-dev --optimize-autoloader

# Frontend
RUN npm ci
RUN npm run build

# Права
RUN chown -R www-data:www-data storage bootstrap/cache

# Apache VirtualHost
RUN cat <<'EOF' > /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]