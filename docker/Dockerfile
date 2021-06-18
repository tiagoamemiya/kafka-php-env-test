FROM php:7.4-alpine

RUN apk add --update --no-cache curl librdkafka-dev $PHPIZE_DEPS
RUN pecl install rdkafka

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN ln -s /opt/remi/php74/root/usr/bin/pecl /usr/bin/pecl

RUN mkdir -p /code

WORKDIR /code