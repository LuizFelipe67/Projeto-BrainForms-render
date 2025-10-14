#!/bin/bash
set -e

# Aguarda alguns segundos para garantir que o banco de dados esteja pronto
sleep 10

# Testa conexão com o banco de dados
echo "Testing database connection..."
php artisan db:monitor

# Gera APP_KEY se não existir
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# Garante que o storage está configurado
php artisan storage:link

# Executa as migrações do banco de dados (com refresh em produção)
if [ "$APP_ENV" = "production" ]; then
    echo "Running migrations in production mode..."
    php artisan migrate:refresh --force --seed
else
    echo "Running migrations in development mode..."
    php artisan migrate --force
fi

# Limpa e recria os caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Inicia o Apache
exec apache2-foreground