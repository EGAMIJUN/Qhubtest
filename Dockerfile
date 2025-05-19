FROM php:8.2-cli

# Node.jsと必要パッケージをインストール
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    zip \
    sqlite3 \
    libsqlite3-dev \
    libzip-dev \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    gnupg \
    ca-certificates \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Composer を追加
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションのセットアップ
WORKDIR /app
COPY . /app
COPY .env /app/.env

# Laravel の初期化
RUN composer install \
    && npm install \
    && npm run build \
    && php artisan config:clear \
    && php artisan key:generate \
    && php artisan migrate --seed || true

EXPOSE 10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
