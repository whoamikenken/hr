FROM php:8.1.6-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

RUN apt-get update

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    libxslt1-dev \
    unzip \
    sudo

# Install required PHP extensions
RUN docker-php-ext-install \
    gd \
    intl \
    xsl \
    mbstring \
    pdo_mysql \
    xsl \
    zip \
    soap


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
RUN chown -R www-data:www-data /var/www

# Set working directory
WORKDIR /var/www

USER $user