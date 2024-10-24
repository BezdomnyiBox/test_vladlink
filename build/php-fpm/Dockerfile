# Используем базовый образ PHP с PHP-FPM
FROM php:8.2-fpm

# Устанавливаем необходимые расширения PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring pdo pdo_mysql mysqli exif pcntl bcmath xml \
    && apt-get clean

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Экспонируем порт для PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
