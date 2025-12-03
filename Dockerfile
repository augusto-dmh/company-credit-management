FROM php:8.3-cli

# Install app dependencies and necessary php extensions
RUN apt-get update && apt-get install -y \
    curl \
    gnupg2 \
    ca-certificates \
    git \
    unzip \
    libsqlite3-dev \
    build-essential \
    && docker-php-ext-install pdo_sqlite bcmath

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Create a user with the same UID as my local user
ARG UID=1000
ARG GID=1000
RUN groupadd -g $GID laravel && \
    useradd -u $UID -g laravel -m laravel

# Composer install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Change ownership of the working directory
RUN chown -R laravel:laravel /var/www/html

# Switch to the new user
USER laravel

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]