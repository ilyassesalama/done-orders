FROM php:8.2-alpine

WORKDIR /app

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json .

RUN composer install

COPY . .

CMD ["composer", "run", "dev"]