FROM php:8.2-cli

# Install dependencies
RUN apt-get update --fix-missing && \
    apt-get install -y zip unzip libonig-dev libicu-dev libzip-dev libpq-dev \
    build-essential libssl-dev zlib1g-dev curl git && \
    docker-php-ext-install pdo zip pdo_pgsql pgsql opcache intl bcmath mbstring && \
    docker-php-ext-enable pdo zip pdo_pgsql pgsql opcache intl bcmath mbstring && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy app
COPY . /var/www

# Permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Install dependencies
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction --ignore-platform-req=ext-mongodb

# Run migrations
RUN php saya migrate --force

# Laravel setup
RUN php saya key
RUN php saya view:cache

# Serve Laravel from built-in PHP server (good for Railway)
ENV PORT=8000
EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
