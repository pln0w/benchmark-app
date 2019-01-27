FROM php:7.3.1-cli

RUN apt-get update \
	&& apt-get install -y \
		git \
		zip \
		unzip

RUN apt-get autoremove \
    && apt-get autoclean \
    && apt-get clean  \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install \
        xdebug-2.7.0beta1 \
    && docker-php-ext-enable \
        xdebug

ENV XDEBUG_EXT zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20170718/xdebug.so
RUN alias php_xdebug="php -d$XDEBUG_EXT vendor/bin/phpunit"

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer \
    && composer global require hirak/prestissimo

RUN curl -OL https://phar.phpunit.de/phpunit.phar \
	&& chmod 755 phpunit.phar \
	&& mv phpunit.phar /usr/local/bin/ \
	&& ln -s /usr/local/bin/phpunit.phar /usr/local/bin/phpunit

WORKDIR /app
ADD ./app /app

RUN usermod -o -u 1000 www-data
RUN chown -R www-data:1000 /app

CMD ["composer", "install"]
