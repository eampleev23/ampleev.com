FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies (cached layer)
# Use faster mirrors and configure retries
RUN echo 'Acquire::Retries "3";' > /etc/apt/apt.conf.d/80-retries && \
    echo 'Acquire::http::Timeout "20";' >> /etc/apt/apt.conf.d/80-retries && \
    echo 'Acquire::https::Timeout "20";' >> /etc/apt/apt.conf.d/80-retries && \
    apt-get update -o Acquire::Retries=3 -o Acquire::http::Timeout=20 && \
    apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip && \
    rm -rf /var/lib/apt/lists/*

# Install PHP extensions (separate layer for better caching)
RUN docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer (cached layer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
