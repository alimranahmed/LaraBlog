#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}===================================${NC}"
echo -e "${GREEN}  LaraBlog Docker Setup${NC}"
echo -e "${GREEN}===================================${NC}"
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}Error: Docker is not running. Please start Docker and try again.${NC}"
    exit 1
fi

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${YELLOW}Creating .env file from .env.docker...${NC}"
    cp .env.docker .env
    
    # Set to local environment by default
    sed -i.bak 's/APP_ENV=production/APP_ENV=local/' .env
    sed -i.bak 's/APP_DEBUG=false/APP_DEBUG=true/' .env
    rm .env.bak
    
    echo -e "${GREEN}✓ .env file created${NC}"
else
    echo -e "${YELLOW}.env file already exists, skipping...${NC}"
fi

# Build and start containers
echo -e "${YELLOW}Building and starting Docker containers...${NC}"
docker compose up -d --build

# Wait for MySQL to be ready
echo -e "${YELLOW}Waiting for MySQL to be ready...${NC}"
sleep 10

# Install composer dependencies (for local development)
if grep -q "APP_ENV=local" .env; then
    echo -e "${YELLOW}Installing composer dependencies...${NC}"
    docker compose exec -T app composer install
    
    echo -e "${YELLOW}Installing npm dependencies...${NC}"
    docker compose exec -T app npm install
fi

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    echo -e "${YELLOW}Generating application key...${NC}"
    docker compose exec -T app php artisan key:generate
    echo -e "${GREEN}✓ Application key generated${NC}"
fi

# Run migrations and seeders
echo -e "${YELLOW}Running database migrations and seeders...${NC}"
docker compose exec -T app php artisan migrate --seed --force

# Set proper permissions
echo -e "${YELLOW}Setting storage permissions...${NC}"
docker compose exec -T app chown -R www-data:www-data /var/www/html/storage
docker compose exec -T app chmod -R 775 /var/www/html/storage

echo ""
echo -e "${GREEN}===================================${NC}"
echo -e "${GREEN}  Setup Complete! 🎉${NC}"
echo -e "${GREEN}===================================${NC}"
echo ""
echo -e "Application URL: ${GREEN}http://localhost:1013${NC}"
echo -e "Mailpit UI: ${GREEN}http://localhost:1028${NC}"
echo ""
echo -e "Admin Login:"
echo -e "  Email: ${GREEN}owner@gmail.com${NC}"
echo -e "  Password: ${GREEN}owner${NC}"
echo ""
echo -e "Useful commands:"
echo -e "  ${YELLOW}./run php artisan [command]${NC}  - Run artisan commands"
echo -e "  ${YELLOW}make logs${NC}                    - View logs"
echo -e "  ${YELLOW}make down${NC}                    - Stop containers"
echo -e "  ${YELLOW}make shell${NC}                   - Access app container"
echo ""
