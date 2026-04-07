#!/bin/sh
set -e

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
until php artisan db:show > /dev/null 2>&1; do
    echo "MySQL is unavailable - sleeping"
    sleep 2
done

echo "MySQL is up - executing command"

# Run migrations if in production
if [ "$APP_ENV" = "production" ]; then
    echo "Running migrations..."
    php artisan migrate --force --no-interaction
fi

# Cache optimization for production
if [ "$APP_ENV" = "production" ]; then
    echo "Optimizing application..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Create supervisor log directory
mkdir -p /var/log/supervisor

# Execute the main command
exec "$@"
