# 🐳 LaraBlog Docker Quick Reference

## 🚀 Quick Start

### First Time Setup
```bash
./docker-setup.sh
# OR
make setup
```

### Manual Start
```bash
docker compose up -d
```

---

## 📦 Common Commands

### Container Management
| Command | Description |
|---------|-------------|
| `make up` | Start all containers |
| `make down` | Stop all containers |
| `make restart` | Restart all containers |
| `make logs` | View logs (follow mode) |
| `make clean` | Stop and remove all data |
| `make fresh` | Fresh install with database reset |

### Application Access
| Service | URL | Description |
|---------|-----|-------------|
| Web App | http://localhost | Main application |
| Mailpit | http://localhost:8025 | Email testing UI |
| MySQL | localhost:3306 | Database (user: larablog) |
| Redis | localhost:6379 | Cache server |

### Admin Login
- Email: `owner@gmail.com`
- Password: `owner`

---

## 🛠️ Development

### Access Container
```bash
make shell
# OR
docker compose exec app sh
```

### Run Artisan Commands
```bash
make artisan CMD="migrate"
make artisan CMD="make:controller UserController"
# OR
docker compose exec app php artisan migrate
```

### Database Operations
```bash
make migrate              # Run migrations
make seed                 # Run seeders
make mysql                # Access MySQL CLI
docker compose exec app php artisan migrate:fresh --seed
```

### Composer & NPM
```bash
make composer CMD="require package/name"
make npm CMD="install"
# OR
docker compose exec app composer require package/name
docker compose exec app npm install
```

---

## 🧹 Maintenance

### Clear Caches
```bash
make cache-clear
# OR
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear
```

### Optimize for Production
```bash
make optimize
# OR
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
```

### Fix Permissions
```bash
make permissions
```

### View Logs
```bash
# All services
docker compose logs -f

# Specific service
docker compose logs -f app
docker compose logs -f nginx
docker compose logs -f mysql

# Queue worker logs
docker compose exec app tail -f /var/log/supervisor/queue-worker.out.log
```

---

## 🧪 Testing

```bash
make test
# OR
docker compose exec app php artisan test
```

---

## 🔧 Troubleshooting

### Rebuild Everything
```bash
docker compose down -v
docker compose build --no-cache
docker compose up -d
```

### Check Service Status
```bash
docker compose ps
```

### Access Specific Service
```bash
docker compose exec mysql sh
docker compose exec redis sh
docker compose exec nginx sh
```

### Database Backup
```bash
docker compose exec mysql mysqldump -u larablog -p larablog > backup.sql
```

### Database Restore
```bash
docker compose exec -T mysql mysql -u larablog -p larablog < backup.sql
```

---

## 📚 Documentation

- Full Documentation: [DOCKER.md](DOCKER.md)
- Make Commands: `make help`
- Docker Compose Docs: https://docs.docker.com/compose/

---

## 🌍 Environment Variables

Key variables in `.env`:

```bash
APP_ENV=local              # local or production
APP_DEBUG=true             # true for dev, false for prod
APP_PORT=80                # Web server port
DB_PASSWORD=secret         # Database password
REDIS_HOST=redis           # Redis host (use 'redis' in Docker)
MAIL_HOST=mailpit          # Mail host (use 'mailpit' in Docker)
```

---

## 🔒 Production Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Use strong `DB_PASSWORD` and `DB_ROOT_PASSWORD`
- [ ] Set proper `APP_URL`
- [ ] Configure `MAIL_FROM_ADDRESS`
- [ ] Set up HTTPS (reverse proxy)
- [ ] Run `make optimize`
- [ ] Test backup/restore procedure
- [ ] Configure firewall rules

---

**Need help?** Check `make help` or see [DOCKER.md](DOCKER.md)
