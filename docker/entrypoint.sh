#!/bin/sh
set -e

# ============================================
# Entrypoint: khởi tạo Laravel trước khi chạy PHP-FPM
# ============================================

# Storage link
php artisan storage:link 2>/dev/null || true

# Generate APP_KEY nếu chưa có
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate --force 2>/dev/null || true
fi

# Đợi database sẵn sàng kết nối
echo "Waiting for database connection..."
php -r "
\$max_attempts = 30;
for (\$i = 0; \$i < \$max_attempts; \$i++) {
    try {
        new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        echo 'Database connected successfully.\n';
        exit(0);
    } catch (PDOException \$e) {
        echo 'Database connection failed, retrying in 2 seconds...\n';
        sleep(2);
    }
}
exit(1);
"

# Chạy migrations
echo "Running migrations..."
php artisan migrate --force

# Chạy seeders
echo "Seeding database..."
php artisan db:seed --force

# Caching Laravel configuration, routes, views, events
echo "Optimizing application cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

exec "$@"
