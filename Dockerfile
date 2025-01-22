FROM php:8.2-fpm-alpine

# Install necessary dependencies
RUN apk update && apk add --no-cache \
    git \
    unzip \
    curl \
    bash \
    nginx \
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

# Copy the Nginx config file
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Expose the port that Nginx will use
EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["/bin/sh", "-c", "nginx & php-fpm"]