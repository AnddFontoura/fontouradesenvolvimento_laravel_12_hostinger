# Sobe/atualiza os containers. Se você mudou uma porta (ou qualquer config)
# no .env, basta rodar `make up` de novo: o Compose detecta a mudança e recria
# apenas os containers afetados, SEM apagar o banco de dados.
up:
	docker compose up -d

# Aplica mudanças do .env/compose recriando os containers necessários,
# preservando o volume do banco.
apply:
	docker compose up -d --remove-orphans

# Para os containers preservando o volume do banco (uso do dia a dia).
stop:
	docker compose stop

# Remove os containers preservando o volume do banco.
down:
	docker compose down --remove-orphans

# Reinicia os containers preservando o volume do banco.
restart:
	docker compose restart

# PERIGO: remove containers E o volume do banco (apaga todos os dados).
# Use apenas quando quiser zerar o banco de propósito.
down-hard:
	docker compose down -v --remove-orphans

# Recria a partir do zero, apagando o banco. Use com cuidado.
reset:
	docker compose down -v --remove-orphans
	docker compose up -d

set-database:
	docker exec -it fontoura_desenvolvimento php artisan migrate
	docker exec -it fontoura_desenvolvimento php artisan db:seed

reset-database:
	docker exec -it fontoura_desenvolvimento php artisan migrate:fresh

# Limpa os caches de config/rota (útil após mudar variáveis do Laravel no .env).
clear-config:
	docker exec -it fontoura_desenvolvimento php artisan optimize:clear

build-js:
	npm run build
