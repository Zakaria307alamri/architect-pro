FROM php:8.2-cli AS vendor
WORKDIR /app

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install intl exif pdo pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-scripts
COPY . .
RUN composer dump-autoload --optimize --no-scripts

FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources resources
COPY vite.config.js .
RUN npm run build

FROM php:8.2-apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN a2enmod rewrite
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install intl exif pdo pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080
ENTRYPOINT ["entrypoint.sh"]
