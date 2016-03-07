FROM php:fpm

# Install PostgreSQL drivers & PHP reqs for Lumen
RUN apt-get update && apt-get install -y libmcrypt-dev libpq-dev libpq5 git
RUN docker-php-ext-install mcrypt mbstring pgsql pdo_pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require hirak/prestissimo