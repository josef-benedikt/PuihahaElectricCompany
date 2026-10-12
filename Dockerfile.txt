FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y git unzip libicu-dev libonig-dev \
    && docker-php-ext-install intl mbstring pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /app/writable \
    && chmod -R 775 /app/writable

ENV CI_ENVIRONMENT=production

CMD sh -c "php spark serve --host 0.0.0.0 --port ${PORT:-8080}"