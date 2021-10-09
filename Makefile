up: ## Start local docker env
up: .env composer-install yarn-install front-build-dev docker-compose-up wait migrate-db

down: ## Stop local docker env
down: docker-compose-down

watch: ## Run webpack watch
	@NODE_ENV=development $(FRONTEND_BUILD) --progress --watch

beautify: ## Beautify your code
	@bin/php-cs-fixer fix -v --show-progress=dots

test: ## Run code tests
	@php artisan test

lint: ## Run code linters
	@bin/psalm
	@bin/php-cs-fixer fix -v --dry-run --show-progress=dots

shell: ## Get access to container
	@$(DOCKER_COMPOSE_EXEC) /bin/sh

migrate-db:
	@$(DOCKER_COMPOSE_EXEC) php artisan migrate

.env:
	@cp .env.docker.dist .env
	@php artisan key:generate

composer-install:
	@composer install

yarn-install:
	@yarn install

docker-compose-up:
	@docker-compose up -d

docker-compose-down:
	@docker-compose down

wait:
	@sleep 5

front-build-dev:
	@NODE_ENV=development $(FRONTEND_BUILD)

front-build-prod:
	@NODE_ENV=production $(FRONTEND_BUILD)

help:
	@printf "\033[33mUsage:\033[0m\n  make TARGET\n\033[33m\nTargets:\n"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//' | awk 'BEGIN {FS = ":"}; {printf "  \033[33m%-15s\033[0m%s\n", $$1, $$2}'

.DEFAULT_GOAL := help
.PHONY: up down beautify test lint shell migrate-db composer-install yarn-install docker-compose-up \
	docker-compose-down wait help front-build-dev

DOCKER_COMPOSE_EXEC = docker-compose exec app
FRONTEND_BUILD = node_modules/webpack/bin/webpack.js --config=node_modules/laravel-mix/setup/webpack.config.js
