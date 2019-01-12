FROM php:7.2-fpm

RUN apt-get update && \
    apt-get upgrade -y

# Install extras
RUN apt-get install -y curl git zlib1g-dev iproute2\
    && docker-php-ext-install pdo pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Install PHP Redis extension
RUN pecl install -o -f redis \
        &&  rm -rf /tmp/pear \
        &&  docker-php-ext-enable redis

# Install Xdebug extension
RUN pecl install xdebug-2.6.1 \
        &&  docker-php-ext-enable xdebug

ENV XDEBUGINI_PATH=/usr/local/etc/php/conf.d/xdebug.ini
RUN echo "zend_extension="`find /usr/local/lib/php/extensions/ -iname 'xdebug.so'` > $XDEBUGINI_PATH
COPY xdebug.ini /tmp/xdebug.ini
RUN cat /tmp/xdebug.ini >> $XDEBUGINI_PATH
RUN echo "\nxdebug.remote_host="`/sbin/ip route|awk '/default/ { print $3 }'` >> $XDEBUGINI_PATH

EXPOSE 22 9000