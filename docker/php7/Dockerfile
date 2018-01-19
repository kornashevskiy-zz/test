FROM php:7.1-fpm

RUN apt-get update && \
    apt-get install -y  git \
            wget \
            zip \
            openjdk-7-jre \
            libpq-dev \
            libicu-dev \
            npm \
            libfreetype6-dev \
            libmcrypt-dev \
            libmemcached-dev \
            libjpeg62-turbo-dev \
            libpng12-dev \
            && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
            && docker-php-ext-install -j$(nproc) gd

### composer
RUN cd / && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install \
    intl \
    exif \
    bcmath \
    zip \
    opcache \
    mbstring \
    -j$(nproc) iconv mcrypt \
    pdo \
    pdo_mysql

RUN cat /usr/share/zoneinfo/Europe/Moscow > /etc/localtime

RUN yes | pecl install xdebug \
&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini



### copy php config files
COPY ./config/ /usr/local/etc/

RUN ln -s /usr/bin/nodejs /usr/bin/node

WORKDIR /var/www
