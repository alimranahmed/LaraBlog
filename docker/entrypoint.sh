#!/bin/sh
set -e

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
until php -r '
$env = file_exists(".env") ? parse_ini_file(".env") : [];
$host = getenv("DB_HOST") ?: ($env["DB_HOST"] ?? "mysql");
$port = getenv("DB_PORT") ?: ($env["DB_PORT"] ?? "3306");
$database = getenv("DB_DATABASE") ?: ($env["DB_DATABASE"] ?? "larablog");
$username = getenv("DB_USERNAME") ?: ($env["DB_USERNAME"] ?? "root");
$password = getenv("DB_PASSWORD");
if ($password === false) {
    $password = $env["DB_PASSWORD"] ?? "";
}
new PDO("mysql:host={$host};port={$port};dbname={$database}", $username, $password, [
    PDO::ATTR_TIMEOUT => 2,
]);
' > /dev/null 2>&1; do
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
