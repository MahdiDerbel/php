FROM php:7.2-apache
COPY src/ /var/www/html/
RUN echo "ServerName localhost">> /etc/apache2/apache2.conf
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite
EXPOSE 99
