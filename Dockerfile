FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libicu-dev \
    libxml2-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install intl zip pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/z-test-yugrin

COPY . .

RUN composer install --no-interaction --no-progress

RUN chown -R www-data:www-data var/ public/

COPY docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

CMD ["php-fpm"]
