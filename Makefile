up: ## Run local docker env
up: copy-env composer-install yarn-install docker-compose-up

down: ## Stop local docker env
down: docker-compose-down

copy-env: \
    if [ ! -f .env ]; then \
        cp .env.docker.dist .env \
    fi

composer-install: composer install

yarn-install: yarn install

docker-compose-up: docker-compose up

docker-compose-down: docker-compose down

help:
	@echo "\033[33mUsage:\033[0m\n  make TARGET\n\033[33m\nTargets:"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//' | awk 'BEGIN {FS = ":"}; {printf "  \033[33m%-10s\033[0m%s\n", $$1, $$2}'

.DEFAULT_GOAL := help
