# Stage 1: Runtime
FROM php:8.4-fpm-alpine

# 1. Install all dependencies, PHP extensions and SUPERVISOR
RUN set -ex \
    && apk update \
    && apk add --no-cache \
    nodejs \
    npm \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    postgresql-dev \
    icu-dev \
    oniguruma-dev \
    supervisor \
    dcron \
    autoconf \
    g++ \
    make

# 2. Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_pgsql \
    pgsql \
    gd \
    zip \
    bcmath \
    intl \
    opcache \
    && pecl install redis \
    && docker-php-ext-enable redis

# 3. Copy PHP configuration for production
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set working directory
WORKDIR /var/www

# 6. Copy package.json and package-lock.json (First install dependencies of Frontend)
COPY package*.json ./
RUN npm install --legacy-peer-deps

# 7. Install dependencies of PHP (Optimize for production)
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm run build && rm -rf node_modules

# 8. Schedule Laravel tasks
RUN echo "* * * * * php /var/www/artisan schedule:run >> /dev/null 2>&1" > /etc/crontabs/www-data

# 9. Adjust permissions for Laravel (Add bootstrap/cache)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/build

# 10. Supervisor configuration
# Copy the config to the standard Alpine path for supervisor
COPY docker/supervisor/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

# 11. Entry point script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

# Use entrypoint to start FPM and Supervisor at the same time
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
