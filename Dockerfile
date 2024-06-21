FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install intl pdo pdo_mysql mbstring zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

COPY . .

RUN composer install

# Permissions for Symfony
RUN chown -R www-data:www-data /var/www/var

CMD ["php-fpm"]
