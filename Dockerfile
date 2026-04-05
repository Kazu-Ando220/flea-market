FROM php:8.4-fpm

# 必要なライブラリのインストール
RUN apt-get update && apt-get install -y \
    nodejs \
    npm \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    postgresql-client \
    zip \
    unzip \
    nginx

# PHP拡張機能のインストール
RUN docker-php-ext-install pdo_mysql mbstring gd
RUN docker-php-ext-install pdo_pgsql

# Composerをコピー
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# ソースコードをコピー
COPY . .

# Composerで依存パッケージをインストール
RUN composer install --no-dev --optimize-autoloader

# フロントエンドビルド（Vite）
RUN npm install && npm run build

# storageのパーミッション設定
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# nginx設定
COPY docker/nginx/default.conf /etc/nginx/sites-enabled/default

EXPOSE 8080

# コンテナ起動時処理
CMD bash -c "php artisan migrate --force && php-fpm -D && nginx -g 'daemon off;'"