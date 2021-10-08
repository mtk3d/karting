up: ## Start local docker env
	@copy-env composer-install yarn-install docker-compose-up migrate-db

down: ## Stop local docker env
	@docker-compose-down

beautify: ## Beautify your code
	bin/php-cs-fixer fix -v --show-progress=dots

test: ## Run code tests
	php artisan test

lint: ## Run code linters
	bin/psalm
	bin/php-cs-fixer fix -v --dry-run --show-progress=dots

migrate-db:
	@$(DOCKER_COMPOSE_EXEC) artisan migrate

copy-env:
	@test -s .env || cp .env.docker.dist .env

composer-install:
	@composer install

yarn-install:
	@yarn install

docker-compose-up:
	@docker-compose up -d

docker-compose-down:
	@docker-compose down

help:
	@echo "\033[33mUsage:\033[0m\n  make TARGET\n\033[33m\nTargets:"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//' | awk 'BEGIN {FS = ":"}; {printf "  \033[33m%-15s\033[0m%s\n", $$1, $$2}'

.DEFAULT_GOAL := help

DOCKER_COMPOSE_EXEC = docker-compose exec app
