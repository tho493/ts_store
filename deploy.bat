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

echo [Done] Deploy completed
pause
