# Escolhe a imagem oficial do PHP com Apache e extensões necessárias
FROM php:8.3-apache

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-install pdo_pgsql zip

# Instala composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia os arquivos da API
COPY . /var/www/html

# Define working directory
WORKDIR /var/www/html

# Instala dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Configura permissões de storage e cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expõe porta (Render define via $PORT)
EXPOSE 10000

# Comando para rodar a aplicação
CMD php artisan serve --host 0.0.0.0 --port 10000
