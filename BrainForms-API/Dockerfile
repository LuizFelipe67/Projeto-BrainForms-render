# ======================================
# Dockerfile para Laravel (BrainForms API)
# ======================================

# Imagem base PHP com Apache
FROM php:8.3-apache

# -------------------------------
# Instala dependências do sistema
# -------------------------------
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-install pdo_pgsql zip

# -------------------------------
# Instala Composer
# -------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -------------------------------
# Define o diretório de trabalho
# -------------------------------
WORKDIR /var/www/html

# -------------------------------
# Copia os arquivos da API
# -------------------------------
COPY . .

# -------------------------------
# Instala dependências do Laravel
# -------------------------------
RUN composer install --no-dev --optimize-autoloader

# -------------------------------
# Permissões para Laravel
# -------------------------------
RUN chown -R www-data:www-data storage bootstrap/cache

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
# Expõe a porta
# -------------------------------
EXPOSE 10000

# -------------------------------
# Comando para iniciar Apache no foreground
# -------------------------------
CMD ["apache2-foreground"]
