FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www

# Copy Nginx config
COPY nginx.conf /etc/nginx/nginx.conf

# Expose port (Render injects PORT at runtime)
EXPOSE 80

# Start both PHP-FPM and Nginx
CMD sh -c "php-fpm -D && nginx -g 'daemon off;'"