FROM php:8.1.23-zts-alpine3.18

WORKDIR /laravel-starter

RUN chown -R root /laravel-starter

COPY . .

COPY .env-sail .env

RUN apt-get update && apt-get install -y \
    curl \
    git \
    zip \
    unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

RUN php artisan key:generate

RUN apt install nginx

RUN docker-php-ext-install pdo pdo_mysql

RUN php artisan migrate

RUN php artisan db:seed

RUN sail up

Run alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

RUN sail artisan migrate --seed

RUN sail artisan storage:link

CMD [ "php", "artisan", "serve", "--host=0.0.0.0" ]

