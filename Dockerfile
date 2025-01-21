FROM php:8.1-fpm-alpine

WORKDIR /var/www/html

RUN apk update && apk add --no-cache \
    git \
    unzip \
    curl

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . .

RUN composer install --no-scripts --no-dev

RUN php artisan key:generate
    
RUN chmod -R 775 storage

EXPOSE 9000

CMD ["php-fpm"]