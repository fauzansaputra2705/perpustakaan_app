FROM php:8.1.5-apache-buster

RUN apt-get update && apt-get install -y libzip-dev libpng-dev zlib1g-dev libwebp-dev

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8d$
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

RUN apt-get update && apt-get install -y && apt-get clean
RUN apt-get install -y nano zip curl build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libicu-dev && apt-get update && apt-get clean
RUN docker-php-ext-install intl gd zip mysqli gettext gd zip pdo pdo_mysql
RUN docker-php-ext-configure intl

COPY docker/site.conf /etc/apache2/sites-enabled/000-default.conf
WORKDIR /var/www/html/app
COPY . /var/www/html/app
RUN composer install
RUN npm install
RUN npm run build
RUN a2enmod rewrite

COPY docker/php.ini /usr/local/etc/php
CMD ["apache2-foreground"]

ADD start.sh /start.sh
RUN chmod 777 /start.sh

ENTRYPOINT ["/start.sh"]
