@echo off
chcp 65001 >nul
setlocal

:: ============================================
:: Deploy script cho TS Battery (Windows)
:: Usage: deploy.bat [branch]
:: ============================================

set BRANCH=%~1
if "%BRANCH%"=="" set BRANCH=main

echo 🚀 Deploying TS Battery...
echo 📌 Branch: %BRANCH%
echo.

:: 1. Pull latest code
echo 📥 Pulling latest code...
git pull origin %BRANCH%
if errorlevel 1 (
    echo ❌ Git pull failed!
    exit /b 1
)

:: 2. Build & restart containers
echo 🔨 Building containers...
docker compose build app nginx
if errorlevel 1 (
    echo ❌ Build failed!
    exit /b 1
)

echo 🔄 Restarting services...
docker compose up -d --no-deps app nginx

:: 3. Wait for app container
echo ⏳ Waiting for app container...
timeout /t 5 /nobreak >nul

:: 4. Laravel optimizations
echo ⚡ Running Laravel optimizations...
docker compose exec -T app php artisan migrate --force
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache
docker compose exec -T app php artisan event:cache

echo.
echo ✅ Deploy completed!
pause
