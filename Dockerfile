FROM php:8.2-apache

ARG XDE=0

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        git \
        zip \
        unzip \
        libsodium-dev \
        cron \
        vim \
        libpq-dev \
        supervisor\
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure sodium \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pdo_pgsql

#Xdebug - should be removed for prod
RUN echo "Install XDE: ${XDE}"
RUN if [ $XDE -eq 1 ]; then pecl install xdebug; fi

COPY .docker/php/php.ini /usr/local/etc/php/conf.d/
COPY .docker/opcache/opcache.ini /usr/local/etc/php/conf.d/

# Set working directory
WORKDIR /var/www/html


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents
COPY . /var/www/html

# Composer install
RUN composer install -o --no-cache
#RUN composer update --no-scripts
RUN composer dump-autoload -o

#Apache2
ENV PORT=8081
RUN rm -f /etc/apache2/sites-available/*
RUN rm -f /etc/apache2/sites-enabled/*

#Cron
COPY .docker/cron/cronjob /etc/cron.d/cronjob

#ADD port
RUN echo "Listen ${PORT}" > /etc/apache2/ports.conf

COPY .docker/apache2/app.conf  /etc/apache2/sites-available/

RUN a2ensite app
RUN a2enmod rewrite
RUN a2enmod headers

# Allow app to write files
RUN mkdir -p /var/www/html/storage/jwks
RUN mkdir -p /var/www/html/storage/framework/cache/data
RUN mkdir -p /var/www/html/storage/framework/views
RUN chmod -R 777 /var/www/html/storage

# Expose port and start apache2 server
EXPOSE ${PORT}

RUN sed -i 's/^exec /service cron start\n\nexec /' /usr/local/bin/apache2-foreground

# Queue supervisor
COPY .docker/supervisor/app-worker.conf /etc/supervisor/conf.d/

# Start container with entrypoint
RUN chmod 777 ./.docker/entrypoint.sh

ENTRYPOINT ["./.docker/entrypoint.sh"]
