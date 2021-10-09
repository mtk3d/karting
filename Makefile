up: ## Start local docker env
up: vendor node_modules .env docker-compose-up front-build-dev migrate-db

down: ## Stop local docker env
down: docker-compose-down

watch: ## Run webpack watch
	@$(NODE) $(FRONTEND_BUILD) --progress --watch

beautify: ## Beautify your code
	@$(DOCKER_COMPOSE_EXEC) $(PHP_CS_FIXER)

test: ## Run code tests
	@$(DOCKER_COMPOSE_EXEC) $(BACKEND_TEST)

lint: ## Run code linters
	@$(DOCKER_COMPOSE_EXEC) $(PSALM)
	@$(DOCKER_COMPOSE_EXEC) $(PHP_CS_FIXER_CHECK)

update: ## Update all dependencies
	@$(COMPOSER) composer update --ignore-platform-reqs
	@$(NODE) yarn upgrade

shell: ## Get access to container
	@$(DOCKER_COMPOSE_EXEC) /bin/sh

migrate-db:
	@$(DOCKER_COMPOSE_EXEC) php artisan migrate

.env:
	@cp .env.docker.dist .env
	@$(DOCKER_COMPOSE_EXEC) artisan key:generate

vendor: composer.json composer.lock
	@$(COMPOSER) composer install --ignore-platform-reqs

node_modules: package.json yarn.lock
	@$(NODE) yarn install

docker-compose-up:
	@docker-compose up -d

docker-compose-down:
	@docker-compose down

front-build-dev:
	@$(NODE) $(FRONTEND_BUILD)

front-build-prod:
	@$(NODE) $(FRONTEND_BUILD)

ci-lint:
	@$(PSALM)
	@$(PHP_CS_FIXER_CHECK)

ci-test:
	@$(BACKEND_TEST)

help:
	@printf "\033[33mUsage:\033[0m\n  make TARGET\n\033[33m\nTargets:\n"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//' | awk 'BEGIN {FS = ":"}; {printf "  \033[33m%-15s\033[0m%s\n", $$1, $$2}'

.DEFAULT_GOAL := help
.PHONY: up down beautify test lint shell migrate-db docker-compose-up docker-compose-down help update \
	front-build-dev front-build-prod ci-lint ci-test

# Docker executable prefix
DOCKER_COMPOSE_EXEC = docker-compose exec app
DOCKER_RUN = docker run --rm -it -w /app -v $(shell pwd):/app

# Docker executables
NODE = $(DOCKER_RUN) node:16.10-alpine
COMPOSER = $(DOCKER_RUN) composer:2.1

# Commands
FRONTEND_BUILD = node_modules/webpack/bin/webpack.js --config=node_modules/laravel-mix/setup/webpack.config.js
PSALM = bin/psalm
PHP_CS_FIXER = bin/php-cs-fixer fix -v --show-progress=dots
PHP_CS_FIXER_CHECK = $(PHP_CS_FIXER) --dry-run
BACKEND_TEST = php artisan test
