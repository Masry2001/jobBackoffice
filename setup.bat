@echo off
echo Setting up Job Backoffice Application...
echo.

REM Check if Docker is running
docker info >nul 2>&1
if errorlevel 1 (
    echo Docker is not running. Please start Docker Desktop first.
    echo Download from: https://www.docker.com/products/docker-desktop
    pause
    exit /b 1
)

REM Create .env file if it doesn't exist
if not exist .env (
    echo Creating .env file from .env.example...
    copy .env.example .env
) else (
    echo .env file already exists
)

REM Stop and remove existing containers
echo Cleaning up existing containers...
docker-compose down -v >nul 2>&1

REM Build and start containers
echo Building and starting Docker containers...
echo This may take 5-10 minutes on first run...
docker-compose up -d --build

REM Wait for services
echo.
echo Waiting for services to initialize...
echo Database is starting up...
timeout /t 15 /nobreak >nul

echo Waiting for migrations and seeding to complete...
echo This may take a few minutes...
timeout /t 30 /nobreak >nul

REM Check container status
echo.
echo Checking container status...
docker-compose ps

echo.
echo Setup complete!
echo.
echo ================================================
echo Your Job Backoffice is running at:
echo    Application: http://localhost:8000
echo    phpMyAdmin: http://localhost:8081
echo ================================================
echo.
echo Useful Commands:
echo    View logs: docker-compose logs -f backoffice
echo    Restart: docker-compose restart
echo    Stop: docker-compose down
echo    Stop and remove data: docker-compose down -v
echo.
echo Note: Keep this terminal open or the containers running
echo for the job-app to connect to the database.
echo.
pause