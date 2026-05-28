@echo off
setlocal

set BRANCH=%~1
if "%BRANCH%"=="" set BRANCH=main

echo [Deploy] Branch: %BRANCH%

git pull origin %BRANCH%
if errorlevel 1 (
    echo [Error] Git pull failed
    exit /b 1
)

docker compose build app nginx
if errorlevel 1 (
    echo [Error] Build failed
    exit /b 1
)

docker compose up -d --no-deps app nginx

timeout /t 5 /nobreak >nul

docker compose exec -T app php artisan migrate --force
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache
docker compose exec -T app php artisan event:cache

echo [Done] Deploy completed
pause
