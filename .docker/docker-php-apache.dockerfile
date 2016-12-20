FROM php:7.0-apache

MAINTAINER Akos Kiszely

RUN apt-get update && apt-get install -y mysql-client libmysqlclient-dev
#RUN apt-get install libicu-dev
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
#RUN docker-php-ext-install intl
COPY ./.docker/apache2/sites-available/000-default.conf /etc/apache2/sites-available
COPY ./.docker/apache2/sites-available/default-ssl.conf /etc/apache2/sites-available

WORKDIR /var/www/html

EXPOSE 80

