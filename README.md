# DevOps Wiki

Base de conhecimento para times DevOps — Laravel 11, Docker e boas práticas de segurança.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=flat-square&logo=docker)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql)
![Redis](https://img.shields.io/badge/Redis-7.2-DC382D?style=flat-square&logo=redis)
![Tailwind](https://img.shields.io/badge/Tailwind-CSS-06B6D4?style=flat-square&logo=tailwindcss)

## Sobre

Portal de gestão de conhecimento técnico com controle de acesso por roles e grupos de atuação. Case de portfólio DevOps demonstrando infraestrutura containerizada, segurança aplicada e desenvolvimento Laravel.

## Funcionalidades

- Artigos com Markdown, prioridade, produto, área, solicitante e tags
- Controle de acesso: roles (admin/editor/viewer) e grupos de atuação
- Segmentação de conteúdo por grupo — usuário vê apenas artigos do seu grupo
- Painel admin: usuários, grupos, tags e configuração SMTP
- Dark/light mode automático (SO) com toggle manual
- Busca e filtros por prioridade, área e tag

## Stack

| Camada | Tecnologia |
|---|---|
| Backend | Laravel 11 + PHP 8.3 |
| Frontend | Blade + Tailwind CSS + Alpine.js |
| Banco | MySQL 8.0 |
| Cache / Sessão | Redis 7.2 |
| Proxy | nginx 1.25 |
| Containers | Docker Compose |
| Assets | Vite 8 + Node 22 |
| Auth | Laravel Breeze |

## Como rodar

Requisitos: Docker, Docker Compose, Node 22+

    git clone git@github.com:glauber-arrighi/devops-wiki.git
    cd devops-wiki
    cp .env.example .env
    make setup

Acesse http://localhost:8080

    Login: admin@devops-wiki.local
    Senha: Admin@2026!

## Comandos

    make up        # Sobe containers
    make down      # Para containers
    make shell     # Acessa container app
    make fresh-db  # Recria banco do zero
    make logs      # Logs em tempo real
    make test      # Roda testes

## Segurança

- Headers HTTP via nginx (X-Frame-Options, X-Content-Type-Options)
- CSRF, rate limiting, validação de senha complexa
- Senha SMTP com encrypted cast do Laravel
- Middleware de role e bloqueio de usuários inativos
- Variáveis sensíveis apenas em .env (nunca commitadas)

## Roadmap

- [ ] Upload de anexos
- [ ] Editor TipTap (rich text)
- [ ] Reset de senha por e-mail
- [ ] Deploy GCP com Cloud Run + Cloud SQL
- [ ] CI/CD com GitHub Actions

## Autor

Glauber Arrighi — DevOps Engineer
https://github.com/glauber-arrighi
