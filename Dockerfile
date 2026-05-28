# ============================================
# Stage 1: Build frontend assets (Vite + Tailwind)
# ============================================
FROM node:20-alpine AS node-build

WORKDIR /build

COPY package.json package-lock.json ./
RUN npm ci

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build

# ============================================
# Stage 2: PHP application
# ============================================
FROM php:8.4-fpm-alpine AS app

# Install system dependencies
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache \
    && rm -rf /var/cache/apk/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (better Docker cache)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application source
COPY . .

# Copy built assets from Stage 1
COPY --from=node-build /build/public/build ./public/build

# Finalize composer
RUN composer dump-autoload --optimize \
    && composer run-script post-autoload-dump

# Custom PHP config
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]

# ============================================
# Stage 3: Nginx (chỉ chứa public files)
# ============================================
FROM nginx:alpine AS nginx

# Copy public files từ app stage (đã có built assets)
COPY --from=app /var/www/html/public /var/www/html/public

# Copy nginx config
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
