FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    zip \
    sqlite3 \
    libsqlite3-dev \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app

# .env を app にコピー（この段階なら /app は存在している）
RUN cp .env.example .env

RUN composer install \
    && php artisan config:clear \
    && php artisan key:generate

EXPOSE 10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
