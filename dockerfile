# Dockerfile


FROM php:7.4-apache


RUN a2enmod rewrite


COPY . /var/www/html/


WORKDIR /var/www/html


RUN chown -R www-data:www-data /var/www/html


EXPOSE 80

COPY my-apache-config.conf /etc/apache2/sites-available/000-default.conf
