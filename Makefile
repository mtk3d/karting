up: ## Start local docker env
up: .env composer-install yarn-install docker-compose-up wait migrate-db

down: ## Stop local docker env
down: docker-compose-down

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

help:
	@printf "\033[33mUsage:\033[0m\n  make TARGET\n\033[33m\nTargets:\n"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//' | awk 'BEGIN {FS = ":"}; {printf "  \033[33m%-15s\033[0m%s\n", $$1, $$2}'

.DEFAULT_GOAL := help
.PHONY: up down beautify test lint shell migrate-db composer-install yarn-install docker-compose-up \
	docker-compose-down wait help

DOCKER_COMPOSE_EXEC = docker-compose exec app
