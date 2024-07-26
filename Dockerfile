FROM php:8.1-cli

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app

RUN composer install

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
