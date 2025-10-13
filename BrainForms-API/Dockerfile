# ======================================
# Dockerfile para Laravel (BrainForms API)
# ======================================

# Imagem base PHP com Apache
FROM php:8.3-apache

# -------------------------------
# Instala dependências do sistema
# -------------------------------
RUN apt-get update && apt-get install -y \
    libpq-dev \        # PostgreSQL
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
# Ativa mod_rewrite do Apache
# Necessário para URLs amigáveis do Laravel
# -------------------------------
RUN a2enmod rewrite

# -------------------------------
# Configura DocumentRoot do Apache
# para o diretório public do Laravel
# -------------------------------
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

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
