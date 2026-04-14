# Docker Setup for LaraBlog

This guide will help you run LaraBlog using Docker in both development and production environments.

## Prerequisites

- Docker Engine 20.10+
- Docker Compose v2.0+

## Quick Start

### Automated Setup (Recommended)

Simply run the setup script:

```bash
./docker-setup.sh
```

This will:
- Create and configure `.env` file
- Build and start all containers
- Generate application key
- Run migrations and seeders
- Display access URLs and credentials

### Manual Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/alimranahmed/LaraBlog.git
   cd LaraBlog
   ```

2. **Copy environment file**
   ```bash
   cp .env.docker .env
   ```

3. **Set development environment**
   ```bash
   # Edit .env and set:
   APP_ENV=local
   APP_DEBUG=true
   ```

4. **Start the containers**
   ```bash
   make up
   # OR
   docker compose up -d
   ```

5. **Generate application key**
   ```bash
   ./run php artisan key:generate
   ```

6. **Run migrations and seeders**
   ```bash
   ./run php artisan migrate --seed
   ```

7. **Access the application**
   - Web: http://localhost:1013
   - Mailpit UI: http://localhost:1028

### Using the `run` Script

The `./run` script makes it easy to execute commands inside the app container:

```bash
./run php artisan migrate       # Run migrations
./run composer install          # Install dependencies
./run npm run dev              # Build assets
./run sh                       # Access shell
```

### Using Makefile

For convenience, common commands are available via Makefile:

```bash
make up         # Start containers
make down       # Stop containers
make logs       # View logs
make shell      # Access app container
make fresh      # Fresh install with database reset
```

Run `make help` to see all available commands.

For running application commands, use the `./run` script:

```bash
./run php artisan migrate
./run composer install
./run npm run build
```

### Production Deployment

1. **Clone the repository on your server**
   ```bash
   git clone https://github.com/alimranahmed/LaraBlog.git
   cd LaraBlog
   ```

2. **Configure environment**
   ```bash
   cp .env.docker .env
   # Edit .env with production settings
   ```

3. **Set production values in .env**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   
   # Strong passwords
   DB_PASSWORD=your_secure_password
   DB_ROOT_PASSWORD=your_root_password
   
   # Mail configuration
   MAIL_FROM_ADDRESS=noreply@yourdomain.com
   ```

4. **Generate application key**
   ```bash
   docker compose run --rm app php artisan key:generate --show
   # Copy the key and add it to .env as APP_KEY
   ```

5. **Start containers**
   ```bash
   docker compose up -d
   ```

The application will automatically:
- Run database migrations
- Optimize configuration, routes, and views
- Start queue workers and scheduler

## Docker Services

The Docker setup includes the following services:

- **app**: PHP 8.2 FPM (Laravel application)
- **nginx**: Nginx web server (Alpine Linux)
- **mysql**: MySQL 8 database
- **redis**: Redis 8 (cache & sessions)
- **mailpit**: Email testing tool

## Build Stages

The Dockerfile supports three build targets:

- **local/development**: For local development with hot-reload, dev dependencies, and OPcache disabled
- **production**: Optimized for production with built assets, OPcache enabled, and queue workers

The build target is automatically selected based on `APP_ENV` in your `.env` file.

## Common Commands

### Running Commands in Container

Use the `./run` script for all commands inside the app container:

```bash
# Artisan commands
./run php artisan migrate
./run php artisan make:controller UserController
./run php artisan queue:work

# Composer
./run composer install
./run composer require package/name
./run composer update

# NPM
./run npm install
./run npm run dev
./run npm run build

# Shell access
./run sh

# Any command
./run [your-command-here]
```

### Container Management

```bash
make up           # Start all containers
make down         # Stop all containers
make restart      # Restart all containers
make logs         # View all logs
make logs nginx   # View specific service logs
make shell        # Access app container shell
make clean        # Stop and remove all data
make fresh        # Fresh install with database reset
```

### Database Operations

```bash
# Run migrations
./run php artisan migrate

# Seed database
./run php artisan db:seed

# Fresh migration
./run php artisan migrate:fresh --seed

# Access MySQL CLI
docker compose exec mysql mysql -u larablog -p

# Backup
docker compose exec mysql mysqldump -u larablog -p larablog > backup.sql

# Restore
docker compose exec -T mysql mysql -u larablog -p larablog < backup.sql
```

### Queue & Scheduler

Queue workers and scheduler are automatically started in production mode via Supervisor.

```bash
# View queue worker logs
docker compose exec app tail -f /var/log/supervisor/queue-worker.out.log

# Restart queue workers
docker compose exec app supervisorctl restart queue-worker
```

### Asset Building

For development with hot reload:
```bash
# Install Node dependencies (if not using Docker)
npm install

# Run Vite dev server
npm run dev
```

For production:
```bash
# Assets are built during Docker image creation
# To rebuild manually:
docker compose exec app npm run build
```

## Port Configuration

Default ports (can be changed in .env):

- **1013**: Web application (APP_PORT) - external access
- **3313**: MySQL (DB_PORT for external access) - for connecting from host machine
- **6379**: Redis (REDIS_PORT)
- **1025**: Mailpit SMTP (MAILPIT_SMTP_PORT)
- **1028**: Mailpit UI (MAILPIT_UI_PORT)

**Important:** Inside Docker containers, services communicate using internal ports:
- MySQL: Use `DB_HOST=mysql` and `DB_PORT=3306` in `.env`
- Redis: Use `REDIS_HOST=redis` and `REDIS_PORT=6379` in `.env`

The external port 3313 is only for connecting from your host machine (e.g., MySQL Workbench, TablePlus).

## Data Persistence

Docker volumes are used for data persistence:

- `mysql_data`: Database files
- `redis_data`: Redis persistence

To remove all data:
```bash
docker compose down -v
```

## Troubleshooting

### Permission Issues

```bash
docker compose exec app chown -R www-data:www-data /var/www/html/storage
docker compose exec app chmod -R 755 /var/www/html/storage
```

### Rebuild Containers

```bash
docker compose down
docker compose build --no-cache
docker compose up -d
```

### View All Service Logs

```bash
docker compose logs -f
```

## Health Checks

The setup includes health checks for:
- MySQL: Ensures database is ready before app starts
- Redis: Monitors Redis availability

## Security Notes

For production:
1. Change all default passwords in `.env`
2. Set `APP_DEBUG=false`
3. Use HTTPS (configure reverse proxy like Nginx/Traefik)
4. Regularly update Docker images
5. Implement proper backup strategy
6. Restrict exposed ports using firewall

## Updating

```bash
# Pull latest changes
git pull origin main

# Rebuild and restart
docker compose down
docker compose up -d --build

# Run migrations
docker compose exec app php artisan migrate --force
```
