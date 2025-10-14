#!/bin/bash
set -e

# Aguarda alguns segundos para garantir que o banco de dados esteja pronto
sleep 5

# Executa as migrações do banco de dados
php artisan migrate --force

# Limpa e recria os caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Inicia o Apache
exec apache2-foreground