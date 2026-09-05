#!/bin/sh

echo "🚀 Iniciando ambiente Laravel + Frontend..."

cd /var/www

# Instala dependências PHP se a pasta vendor não existir
if [ ! -d "vendor" ]; then
  echo "📦 Instalando dependências PHP (composer)..."
  composer install
else
  echo "✅ Dependências PHP já instaladas."
fi

# Instala dependências Node.js se node_modules não existir.
# O servidor Vite é iniciado pelo container "frontend" (docker-compose),
# então aqui apenas garantimos as dependências instaladas.
if [ -f "package.json" ]; then
  if [ ! -d "node_modules" ]; then
    echo "📦 Instalando dependências Node.js (npm)..."
    npm install
  else
    echo "✅ Dependências Node.js já instaladas."
  fi
else
  echo "⚠️ Nenhum frontend encontrado (package.json não existe)."
fi

# Garante que o .env e chave da aplicação existam
if [ ! -f ".env" ]; then
  echo "⚙️ Copiando .env.example para .env"
  cp .env.example .env
  php artisan key:generate
fi

echo "⏳ Aguardando banco de dados em $DB_HOST:$DB_PORT..."

# Aguarda até conseguir conectar no MySQL
until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "select 1" &> /dev/null; do
  >&2 echo "Banco ainda não está pronto..."
  sleep 2
done

echo "✅ Banco disponível! Executando migrations..."

php artisan migrate
php artisan db:seed

APP_PORT="${APP_PORT:-8132}"
echo "🎯 Iniciando servidor Laravel na porta ${APP_PORT}..."
php artisan serve --host=0.0.0.0 --port="${APP_PORT}"

php artisan storage:link
