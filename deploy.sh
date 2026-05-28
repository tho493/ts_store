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

echo "[Done] Deploy completed"
