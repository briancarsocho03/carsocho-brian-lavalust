FROM php:8.3-apache

WORKDIR /var/www/html

COPY . /var/www/html/

RUN a2enmod rewrite

RUN sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#' /etc/apache2/sites-available/000-default.conf

RUN sed -i 's#<Directory /var/www/>#<Directory /var/www/html/public/>#' /etc/apache2/apache2.conf

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

RUN chown -R www-data:www-data /var/www/html/runtime

EXPOSE 10000

CMD ["sh", "-c", "sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf && sed -i 's/:80>/:10000>/g' /etc/apache2/sites-available/000-default.conf && apache2-foreground"]