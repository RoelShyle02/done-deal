FROM php:8.1-fpm

# Copy composer.lock and composer.json
COPY backend/composer.lock backend/composer.json /var/www/

# Set working directory
WORKDIR /var/www



RUN apt-get update && apt-get install -y \
    wget \
    apt-utils \
    gnupg \
    software-properties-common \
    apt-transport-https \
    libxml2-dev \
    unixodbc-dev


# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip


RUN pecl install sqlsrv pdo_sqlsrv mcrypt-1.0.1

RUN apt-get update \
    && apt-get install --no-install-recommends -y \
    unixodbc-dev \
    && ACCEPT_EULA=Y apt-get install docker --no-install-recommends -y  libxml2-dev  \
    libaio-dev \
    libmemcached-dev 



RUN docker-php-ext-install \
    iconv \
    sockets \
    pdo \
    pdo_mysql \
    && docker-php-ext-enable \
    sqlsrv \
    pdo_sqlsrv

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY ./backend /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www
# After copying the application code
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
