# Build stage para PHP e Node
FROM php:8.2-fpm as builder

# Dependências do sistema para o build
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Composer safe ownership and flags
RUN git config --global --add safe.directory /var/www/html \
 && echo "COMPOSER_ALLOW_SUPERUSER=1" >> /etc/environment

# Instala dependências PHP (sem dev para evitar requisitos de PHP 8.3 nos pacotes de teste)
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --prefer-dist --no-interaction --no-progress -o

# Imagem final
FROM php:8.2-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia o projeto
COPY . .
# Copia vendor do builder (evita rodar composer na imagem final)
COPY --from=builder /var/www/html/vendor /var/www/html/vendor
# Sem assets de frontend

# Não roda composer na imagem final

# Permissões
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
