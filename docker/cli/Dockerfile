FROM php:7.3-cli

RUN apt-get update && docker-php-ext-install pdo_mysql

WORKDIR /usr/src/houseapplication

ENTRYPOINT php multiprocess.php
