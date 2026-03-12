FROM php:8.4-fpm

# 必要なライブラリのインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# PHP拡張機能のインストール
RUN docker-php-ext-install pdo_mysql mbstring gd

# ★ここが重要：Composer を公式イメージからコピー
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# storageディレクトリの権限設定
RUN mkdir -p /var/www/storage && chmod -R 777 /var/www/storage