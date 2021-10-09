.PHONY: up
up: ## Start local docker env
up: .env composer-install yarn-install docker-compose-up wait migrate-db

.PHONY: down
down: ## Stop local docker env
down: docker-compose-down

.PHONY: beautify
beautify: ## Beautify your code
	@bin/php-cs-fixer fix -v --show-progress=dots

.PHONY: test
test: ## Run code tests
	@php artisan test

.PHONY: lint
lint: ## Run code linters
	@bin/psalm
	@bin/php-cs-fixer fix -v --dry-run --show-progress=dots

.PHONY: shell
shell: ## Get access to container
	@$(DOCKER_COMPOSE_EXEC) /bin/sh

.PHONY: migrate-db
migrate-db:
	@$(DOCKER_COMPOSE_EXEC) php artisan migrate

.env:
	@cp .env.docker.dist .env
	@php artisan key:generate

.PHONY: composer-install
composer-install:
	@composer install

.PHONY: yarn-install
yarn-install:
	@yarn install

.PHONY: docker-compose-up
docker-compose-up:
	@docker-compose up -d

.PHONY: docker-compose-down
docker-compose-down:
	@docker-compose down

.PHONY: wait
wait:
	@sleep 5

.PHONY: help
help:
	@printf "\033[33mUsage:\033[0m\n  make TARGET\n\033[33m\nTargets:\n"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//' | awk 'BEGIN {FS = ":"}; {printf "  \033[33m%-15s\033[0m%s\n", $$1, $$2}'

.DEFAULT_GOAL := help

DOCKER_COMPOSE_EXEC = docker-compose exec app
