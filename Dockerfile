FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git zip unzip curl \
    && docker-php-ext-install pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Add composer tools globally available
ENV PATH="/root/.composer/vendor/bin:$PATH"
