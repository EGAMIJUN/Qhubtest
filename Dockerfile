FROM php:8.2-cli

# Node.js を追加するためのパッケージ設定
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
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Composer のインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションのセットアップ
WORKDIR /app
COPY . /app
COPY .env /app/.env 

RUN composer install \
    && npm install \
    && npm run build \
    && php artisan config:clear \
    && php artisan key:generate

EXPOSE 10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
