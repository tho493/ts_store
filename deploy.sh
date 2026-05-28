#!/bin/bash
set -e

BRANCH="${1:-main}"
COMPOSE="docker compose"

echo "[Deploy] Branch: $BRANCH"

git pull origin "$BRANCH"

echo "[Build] Building containers..."
$COMPOSE build app nginx

echo "[Restart] Restarting services..."
$COMPOSE up -d --no-deps app nginx

sleep 5

echo "[Optimize] Running Laravel tasks..."
$COMPOSE exec -T app php artisan migrate --force
$COMPOSE exec -T app php artisan config:cache
$COMPOSE exec -T app php artisan route:cache
$COMPOSE exec -T app php artisan view:cache
$COMPOSE exec -T app php artisan event:cache

echo "[Done] Deploy completed"
