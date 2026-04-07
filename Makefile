.PHONY: help build up down restart logs shell artisan composer npm mysql redis clean fresh test

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Available targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build Docker images
	docker compose build --no-cache

up: ## Start all containers
	docker compose up -d

down: ## Stop all containers
	docker compose down

restart: down up ## Restart all containers

logs: ## Show container logs
	docker compose logs -f

shell: ## Access app container shell
	docker compose exec app sh

artisan: ## Run artisan command (usage: make artisan CMD="migrate")
	docker compose exec app php artisan $(CMD)

composer: ## Run composer command (usage: make composer CMD="install")
	docker compose exec app composer $(CMD)

npm: ## Run npm command (usage: make npm CMD="install")
	docker compose exec app npm $(CMD)

mysql: ## Access MySQL CLI
	docker compose exec mysql mysql -u larablog -p

redis: ## Access Redis CLI
	docker compose exec redis redis-cli

clean: ## Stop containers and remove volumes
	docker compose down -v

fresh: ## Fresh install - rebuild and reset database
	docker compose down -v
	docker compose up -d --build
	@echo "Waiting for MySQL to be ready..."
	@sleep 10
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate:fresh --seed

test: ## Run tests
	docker compose exec app php artisan test

setup: ## Initial setup (creates .env and starts containers)
	./docker-setup.sh

migrate: ## Run database migrations
	docker compose exec app php artisan migrate

seed: ## Run database seeders
	docker compose exec app php artisan db:seed

cache-clear: ## Clear all caches
	docker compose exec app php artisan cache:clear
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan view:clear

optimize: ## Optimize for production
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache

permissions: ## Fix storage permissions
	docker compose exec app chown -R www-data:www-data /var/www/html/storage
	docker compose exec app chmod -R 755 /var/www/html/storage
