FROM ubuntu:16.04

ENV PHPINI_PATH=/etc/php/7.1/cli/conf.d/99-card-battle-game.ini

# Update apt-repository
RUN echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu xenial main" > /etc/apt/sources.list.d/ondrej-ubuntu-php-xenial.list
RUN apt-get update

# Install php and php dependencies
RUN apt-get install -y --allow-unauthenticated \
    php7.1 \
    php7.1-bcmath \
    php7.1-curl \
    php7.1-intl \
    php7.1-mbstring \
    php7.1-json \
    php7.1-xdebug \
    php7.1-dom \
    php7.1-zip \
    curl \
    openssh-client

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/composer

# Configure php
COPY ./build/docker/php/php.ini $PHPINI_PATH
RUN mkdir /tmp/xdebug
RUN echo "xdebug.remote_host="`/sbin/ip route|awk '/default/ { print $3 }'` >> $PHPINI_PATH

COPY . /var/www/card-battle-game

WORKDIR /var/www/card-battle-game

EXPOSE 80

CMD ["sh", "init.sh"]
