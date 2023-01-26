FROM php:8.2-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

RUN apk update; \
    apk upgrade; \
    apk add \
        alpine-sdk \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        zip \
        jpegoptim optipng pngquant gifsicle \
        vim \
        unzip \
        git \
        curl \
        libzip-dev oniguruma-dev \
        imagemagick-dev \
        autoconf \
        bash

# Install Node for PHP (i.e. ShikiPHP)
RUN apk add nodejs
RUN ln -s /usr/bin/node /usr/local/bin/node

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf


# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl bcmath gd
RUN pecl install redis imagick \
	&& docker-php-ext-enable redis imagick
    
USER laravel

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]