#!/bin/bash
set -e

# ============================================
# Deploy script cho TS Battery
# Usage: ./deploy.sh [branch]
# ============================================

BRANCH="${1:-main}"
COMPOSE="docker compose"

echo "🚀 Deploying TS Battery..."
echo "📌 Branch: $BRANCH"
echo ""

# 1. Pull latest code
echo "📥 Pulling latest code..."
git pull origin "$BRANCH"

# 2. Build & restart containers (rebuild app + nginx vì code nằm trong image)
echo "🔨 Building containers..."
$COMPOSE build app nginx

echo "🔄 Restarting services..."
$COMPOSE up -d --no-deps app nginx

# 3. Wait for app container to be ready
echo "⏳ Waiting for app container..."
sleep 5

# 4. Run Laravel optimizations
echo "⚡ Running Laravel optimizations..."
$COMPOSE exec -T app php artisan migrate --force
$COMPOSE exec -T app php artisan config:cache
$COMPOSE exec -T app php artisan route:cache
$COMPOSE exec -T app php artisan view:cache
$COMPOSE exec -T app php artisan event:cache

echo ""
echo "✅ Deploy completed!"
echo "🌐 Website: http://$(hostname -I | awk '{print $1}')"
