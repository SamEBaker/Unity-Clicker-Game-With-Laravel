FROM php:8.4-cli

# Install system deps
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public