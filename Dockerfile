# Gunakan image PHP 8.2 FPM
FROM php:8.2-fpm

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev && \
    docker-php-ext-install pdo mbstring exif pcntl bcmath && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /var/www

# Copy semua file project ke dalam container
COPY . .

# Install dependensi PHP (composer)
RUN composer install --no-interaction --optimize-autoloader

# Expose port PHP-FPM
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]

