#!/bin/sh

# Criar arquivo .env a partir do exemplo
cp .env.example .env

# Configurar variáveis de ambiente
sed -i "s|APP_KEY=|APP_KEY=base64:BTZGbtzJ2K93g96JL8B2v4/2dgZQC7KihgzsMxKVjJQ=|g" .env
sed -i "s|APP_ENV=.*|APP_ENV=production|g" .env
sed -i "s|APP_DEBUG=.*|APP_DEBUG=false|g" .env
sed -i "s|APP_URL=.*|APP_URL=https://brainforms-api.onrender.com|g" .env

# Configurações do banco de dados
sed -i "s|DB_CONNECTION=.*|DB_CONNECTION=pgsql|g" .env
sed -i "s|DB_HOST=.*|DB_HOST=dpg-d3l9u633fgac73ae3q6g-a.oregon-postgres.render.com|g" .env
sed -i "s|DB_PORT=.*|DB_PORT=5432|g" .env
sed -i "s|DB_DATABASE=.*|DB_DATABASE=brainforms_db|g" .env
sed -i "s|DB_USERNAME=.*|DB_USERNAME=brainforms_db_user|g" .env
sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=XPtxXDozktdBbbVDZFfJpni5I6rKyahc|g" .env

# Outras configurações
sed -i "s|SESSION_DRIVER=.*|SESSION_DRIVER=database|g" .env
sed -i "s|CACHE_STORE=.*|CACHE_STORE=database|g" .env
sed -i "s|QUEUE_CONNECTION=.*|QUEUE_CONNECTION=database|g" .env

# Permissões
chmod -R 775 storage bootstrap/cache