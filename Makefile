.PHONY: help up down restart logs shell clean fresh

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'For running commands in container, use: ./run [command]'
	@echo 'Example: ./run php artisan migrate'
	@echo ''
	@echo 'Available targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

up: ## Start all containers
	docker compose up -d

down: ## Stop all containers
	docker compose down

restart: down up ## Restart all containers

logs: ## Show container logs (use: make logs [service])
	docker compose logs -f $(filter-out $@,$(MAKECMDGOALS))

shell: ## Access app container shell
	docker compose exec app sh

clean: ## Stop containers and remove volumes
	docker compose down -v

fresh: ## Fresh install - rebuild and reset database
	docker compose down -v
	docker compose up -d --build
	@echo "Waiting for MySQL to be ready..."
	@sleep 10
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate:fresh --seed

%:
	@:
