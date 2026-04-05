FROM php:8.4-fpm

# 必要なライブラリのインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nginx

# PHP拡張機能のインストール
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# ソースコードをコピー
COPY . .

# Composerで依存パッケージをインストール
RUN composer install --no-dev --optimize-autoloader

# storageのパーミッション設定
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# nginx設定をコピー（既存のdocker/nginx/default.confを流用・中身は修正する）
COPY docker/nginx/default.conf /etc/nginx/sites-enabled/default

EXPOSE 8080

# nginx と php-fpm を同時起動
CMD bash -c "php-fpm -D && nginx -g 'daemon off;'"