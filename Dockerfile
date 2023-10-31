FROM php:8-fpm
RUN apt-get update && apt-get install -y libpq-dev nodejs npm
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql
RUN npm install --global yarn
