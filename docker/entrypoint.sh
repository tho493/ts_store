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

exec "$@"
