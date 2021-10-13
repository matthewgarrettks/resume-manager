FROM alpine:3.14

# Set the timezone
ENV TZ="America/Chicago"
RUN echo $TZ > /etc/timezone

# s6 overlay
RUN set -eux; \
    apk add --no-cache wget; \
    wget https://github.com/just-containers/s6-overlay/releases/download/v2.2.0.3/s6-overlay-amd64-installer -O /tmp/s6-overlay-installer; \
    chmod +x /tmp/s6-overlay-installer; \
    /tmp/s6-overlay-installer /; \
    rm /tmp/s6-overlay-installer

# install standard utils
RUN apk add --no-cache bash curl nginx  git openssh-client openssl yarn nodejs shadow

# install php
RUN apk add --no-cache php8 \
    php8-fpm php8-mbstring php8-ctype php8-iconv php8-mysqlnd \
    php8-phar php8-pdo php8-pdo_mysql \
    php8-zip php8-gd php8-session php8-fileinfo php8-tokenizer php8-dom \
    php8-xmlreader php8-xmlwriter php8-xml php8-curl php8-opcache php8-openssl \
    php8-xdebug php8-json php8-simplexml php8-ldap php8-intl
RUN ln -s /usr/bin/php8 /usr/local/bin/php 

ENV IS_DEV="0"
RUN set -eux; \
    addgroup -S app; \
    adduser -D -S -s /sbin/nologin -G app app

# Composer
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/home/app/.composer
RUN set -eux; \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    chown -R app:app ${COMPOSER_HOME}

# Set up directories
RUN set -eux; \
    mkdir /app; \
    chown -R app:app /app

# Copy configs
COPY ./etc /etc
COPY ./nginx/fastcgi_params /etc/nginx/fastcgi_params
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./nginx/vhost.conf /etc/nginx/conf.d/default.conf
COPY ./php8/ /etc/php8/

RUN set -eux; \
    chown -R app:nginx /var/lib/nginx/tmp; \
    chmod 771 /var/lib/nginx /var/lib/nginx/tmp

ENV APP_ENV="dev"

WORKDIR /app

EXPOSE 80 443

ENTRYPOINT ["/init"]
