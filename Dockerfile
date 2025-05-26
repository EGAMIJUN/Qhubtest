FROM php:8.2-cli

# 必要パッケージのインストール
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
    && docker-php-ext-install pdo pdo_pgsql pdo_sqlite \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Composer の追加
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションのセットアップ
WORKDIR /app
COPY . /app

# Laravel の初期化（buildCommand 側で対応するのでここでは最低限）
RUN composer install \
    && npm install \
    && npm run build

EXPOSE 10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
