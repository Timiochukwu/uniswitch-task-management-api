H 

FROM php:8.2-fpm-alpine

# Install necessary dependencies
RUN apk update && apk add --no-cache \
    git \
    unzip \
    curl \
    bash \
    && rm -rf /var/cache/apk/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy application code to container
COPY . .

# Install Composer dependencies
RUN composer install --no-scripts --no-dev

# Set proper permissions on storage and cache directories
RUN chmod -R 775 storage bootstrap/cache

# Expose the port that the built-in PHP server will use
EXPOSE 8000

# Run the PHP built-in server to serve the Laravel app
CMD php artisan serve --host=0.0.0.0 --port=8000