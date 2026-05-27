# ─────────────────────────────────────────────────────────────────
# devops-wiki — Makefile
# Uso: make <comando>
# ─────────────────────────────────────────────────────────────────

.PHONY: help up down restart build fresh logs shell tinker migrate seed test

# Exibe ajuda
help:
	@echo ""
	@echo "  devops-wiki — comandos disponíveis"
	@echo ""
	@echo "  make up          Sobe todos os containers"
	@echo "  make down        Para e remove containers"
	@echo "  make restart     Reinicia todos os containers"
	@echo "  make build       Rebuilda as imagens"
	@echo "  make fresh       Recria tudo do zero (cuidado!)"
	@echo ""
	@echo "  make install     Instala dependências Laravel"
	@echo "  make migrate     Roda as migrations"
	@echo "  make seed        Popula o banco com dados iniciais"
	@echo "  make fresh-db    migrate:fresh --seed"
	@echo ""
	@echo "  make shell       Acessa o container da app"
	@echo "  make tinker      Abre o Laravel Tinker"
	@echo "  make logs        Exibe logs em tempo real"
	@echo "  make test        Roda os testes"
	@echo ""

# ─── Containers ──────────────────────────────────────────────────
up:
	docker compose up -d
	@echo "✅ devops-wiki rodando em http://localhost:$$(grep APP_PORT .env | cut -d= -f2 || echo 8080)"

down:
	docker compose down

restart:
	docker compose restart

build:
	docker compose build --no-cache

fresh:
	docker compose down -v
	docker compose build --no-cache
	docker compose up -d
	@sleep 5
	$(MAKE) install
	$(MAKE) fresh-db

# ─── Laravel ─────────────────────────────────────────────────────
install:
	docker compose exec app composer install
	@if [ ! -f .env ]; then cp .env.example .env; fi
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan storage:link

migrate:
	docker compose exec app php artisan migrate

seed:
	docker compose exec app php artisan db:seed

fresh-db:
	docker compose exec app php artisan migrate:fresh --seed

# ─── Dev ─────────────────────────────────────────────────────────
shell:
	docker compose exec app bash

tinker:
	docker compose exec app php artisan tinker

logs:
	docker compose logs -f app nginx

test:
	docker compose exec app php artisan test

# ─── Setup inicial ───────────────────────────────────────────────
setup: up
	@sleep 8
	$(MAKE) install
	$(MAKE) fresh-db
	@echo ""
	@echo "🚀 devops-wiki pronto!"
	@echo "   Acesse: http://localhost:$$(grep APP_PORT .env | cut -d= -f2 || echo 8080)"
	@echo "   Admin:  admin@devops-wiki.local / password"
	@echo ""
