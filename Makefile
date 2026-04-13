help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'For running commands in container, use: ./run [command]'
	@echo 'Example: ./run php artisan migrate'
	@echo ''
	@echo 'Available targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

logs: ## Show container logs (use: make logs [service])
	docker compose logs -f $(filter-out $@,$(MAKECMDGOALS))

in: ## Access app container shell
	docker compose exec app sh
