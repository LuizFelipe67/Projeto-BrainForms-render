# ======================================
# Dockerfile para Laravel (BrainForms API)
# Versão: 1.0.1
# ======================================

# Imagem base PHP com Apache
FROM php:8.2-apache

# -------------------------------
# Instala dependências do sistema
# -------------------------------
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_pgsql \
        zip \
        gd \
        bcmath

# -------------------------------
# Instala Composer
# -------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -------------------------------
# Define o diretório de trabalho
# -------------------------------
WORKDIR /var/www/html

# -------------------------------
# Configura ambiente
# -------------------------------
COPY composer.json composer.lock ./
COPY .env.example .env

# -------------------------------
# Script de configuração inline
# -------------------------------
RUN echo '#!/bin/sh\n\
sed -i "s|APP_KEY=|APP_KEY=base64:BTZGbtzJ2K93g96JL8B2v4/2dgZQC7KihgzsMxKVjJQ=|g" .env\n\
sed -i "s|APP_ENV=.*|APP_ENV=production|g" .env\n\
sed -i "s|APP_DEBUG=.*|APP_DEBUG=false|g" .env\n\
sed -i "s|APP_URL=.*|APP_URL=https://brainforms-api.onrender.com|g" .env\n\
sed -i "s|DB_CONNECTION=.*|DB_CONNECTION=pgsql|g" .env\n\
sed -i "s|DB_HOST=.*|DB_HOST=dpg-d3l9u633fgac73ae3q6g-a.oregon-postgres.render.com|g" .env\n\
sed -i "s|DB_PORT=.*|DB_PORT=5432|g" .env\n\
sed -i "s|DB_DATABASE=.*|DB_DATABASE=brainforms_db|g" .env\n\
sed -i "s|DB_USERNAME=.*|DB_USERNAME=brainforms_db_user|g" .env\n\
sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=XPtxXDozktdBbbVDZFfJpni5I6rKyahc|g" .env\n\
sed -i "s|SESSION_DRIVER=.*|SESSION_DRIVER=database|g" .env\n\
sed -i "s|CACHE_STORE=.*|CACHE_STORE=database|g" .env\n\
sed -i "s|QUEUE_CONNECTION=.*|QUEUE_CONNECTION=database|g" .env\n\
chmod -R 775 storage bootstrap/cache' > /usr/local/bin/setup.sh \
    && chmod +x /usr/local/bin/setup.sh \
    && /usr/local/bin/setup.sh

# -------------------------------
# Instala dependências do Laravel
# -------------------------------
RUN composer install --no-dev --no-scripts --prefer-dist --no-progress

# -------------------------------
# Copia o restante dos arquivos da API
# -------------------------------
COPY . .

# -------------------------------
# Finaliza setup do Laravel
# -------------------------------
RUN composer dump-autoload --optimize \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# -------------------------------
# Permissões para Laravel
# -------------------------------
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html/storage -type d -exec chmod 775 {} \; \
    && find /var/www/html/storage -type f -exec chmod 664 {} \;

# -------------------------------
# Ativa mod_rewrite e headers do Apache
# Necessário para URLs amigáveis do Laravel e CORS
# -------------------------------
RUN a2enmod rewrite headers

# -------------------------------
# Configura DocumentRoot e CORS no Apache
# -------------------------------
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Adiciona configurações CORS
RUN echo '<IfModule mod_headers.c>\n\
    Header set Access-Control-Allow-Origin "*"\n\
    Header set Access-Control-Allow-Methods "POST, GET, OPTIONS, DELETE, PUT"\n\
    Header set Access-Control-Allow-Headers "X-Requested-With, Content-Type, X-Token-Auth, Authorization, Accept"\n\
    Header set Access-Control-Max-Age "600"\n\
    \n\
    # Handle OPTIONS preflight requests\n\
    RewriteEngine On\n\
    RewriteCond %{REQUEST_METHOD} OPTIONS\n\
    RewriteRule ^(.*)$ $1 [R=200,L]\n\
</IfModule>' > /etc/apache2/conf-available/cors.conf

RUN a2enconf cors

# -------------------------------
# Define variáveis de ambiente
# -------------------------------
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV PORT=10000

# -------------------------------
# Configura o PHP para produção
# -------------------------------
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i 's/memory_limit = 128M/memory_limit = 256M/g' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/display_errors = Off/display_errors = On/g' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/log_errors = Off/log_errors = On/g' "$PHP_INI_DIR/php.ini"

# Habilita mod_headers para logs detalhados
RUN a2enmod headers

# -------------------------------
# Expõe a porta
# -------------------------------
EXPOSE 10000

# -------------------------------
# Script de entrada para inicialização
# -------------------------------
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# -------------------------------
# Define o comando de entrada
# -------------------------------
ENTRYPOINT ["docker-entrypoint.sh"]
