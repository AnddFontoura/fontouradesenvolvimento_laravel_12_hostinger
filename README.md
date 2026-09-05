# Fontoura Desenvolvimento

Site institucional e painel interno da Fontoura Desenvolvimento.

## Stack

- **Backend:** Laravel 12 (PHP 8.2+), Inertia, Sanctum, Ziggy
- **Frontend:** Vue 3 + Inertia + Tailwind CSS v3 (build com Vite)
- **Auth:** Laravel Breeze (login, registro, reset de senha, verificação de e-mail)
- **Banco:** MySQL 8
- **Ambiente:** Docker (app PHP-FPM, nginx, MySQL e Vite)

> Convenção do projeto: todo o código é escrito em **inglês** (tabelas, colunas,
> classes, variáveis, rotas). Apenas o texto visível ao usuário final fica em
> **português**. Detalhes em `.kiro/steering/conventions.md`.

## Primeiros passos

```bash
# 1. Copie o arquivo de ambiente
cp .env.example .env

# 2. Suba os containers
make up

# 3. (Se necessário) rode as migrations
make set-database
```

A aplicação fica disponível via nginx em `http://localhost:8092`.

## Portas (parametrizadas via `.env`)

As portas dos containers são configuráveis no `.env` para evitar conflito com
outros projetos rodando localmente:

| Variável          | Padrão | Serviço                         |
| ----------------- | ------ | ------------------------------- |
| `APP_PORT`        | `8132` | Servidor Laravel (`artisan serve`) |
| `WEB_PORT`        | `8092` | nginx (entrada web principal)   |
| `DB_FORWARD_PORT` | `3322` | MySQL exposto no host           |
| `VITE_PORT`       | `5185` | Servidor de dev do Vite         |

## Mudei o `.env` — e agora?

Não é necessário derrubar tudo. O comportamento depende do tipo de variável:

| O que você mudou                                              | O que fazer                                                                 |
| ------------------------------------------------------------- | --------------------------------------------------------------------------- |
| Uma **porta** (`APP_PORT`, `WEB_PORT`, `DB_FORWARD_PORT`, `VITE_PORT`) | `make up` — o Compose recria **apenas** os containers afetados, **sem apagar o banco**. |
| Variável comum do Laravel (`APP_NAME`, `DB_*`, etc.)          | Nada. Em local, o `artisan serve` relê o `.env` a cada request.             |
| Variável do Laravel **com config cache ativo**                | `make clear-config`                                                         |

> **Importante:** evite `docker compose down -v` no dia a dia. A flag `-v`
> remove o volume do MySQL e **apaga todos os dados**. Use `make down` /
> `make stop`, que preservam o banco.

## Comandos (Makefile)

| Comando             | O que faz                                                                 |
| ------------------- | ------------------------------------------------------------------------- |
| `make up`           | Sobe/atualiza os containers (recria só o que mudou, preserva o banco).    |
| `make stop`         | Para os containers, preservando o banco.                                  |
| `make down`         | Remove os containers, preservando o banco.                                |
| `make restart`      | Reinicia os containers, preservando o banco.                              |
| `make apply`        | Aplica mudanças do `.env`/compose recriando o necessário.                 |
| `make clear-config` | Limpa caches de config/rota do Laravel.                                   |
| `make set-database` | Roda `migrate` + `db:seed`.                                               |
| `make reset-database` | Roda `migrate:fresh` (recria as tabelas).                               |
| `make build-js`     | Gera o build de produção do frontend (`npm run build`).                   |
| `make down-hard`    | **PERIGO:** remove containers **e o volume do banco** (apaga os dados).   |
| `make reset`        | **PERIGO:** recria tudo do zero, apagando o banco.                        |

## Frontend

- Em desenvolvimento, o container `frontend` roda o Vite automaticamente.
- Para gerar o build de produção: `make build-js` (ou `npm run build`).

## Identidade visual

- Paleta da marca definida como tokens no `tailwind.config.js`: `brand-orange`
  (gradiente do logo) e `brand-dark` (roxo escuro/quase-preto). Use sempre esses
  tokens.
- Logo (dragão) em `public/img/fontoura-dragao.png`, servido pelo componente
  `resources/js/Components/ApplicationLogo.vue`.
