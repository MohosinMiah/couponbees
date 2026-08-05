@echo off
echo ============================================
echo  CouponHub - Auto Setup Script (Windows)
echo  Database: MySQL - couponsite
echo ============================================

echo.
echo [1/5] Installing Composer dependencies...
call composer install --no-interaction
if %ERRORLEVEL% neq 0 ( echo ERROR: composer install failed & pause & exit /b 1 )

echo.
echo [2/5] Copying .env file...
if not exist .env (
    copy .env.example .env
    echo .env created.
) else (
    echo .env already exists, skipping.
)

echo.
echo IMPORTANT: Open .env and set your MySQL credentials:
echo   DB_HOST=127.0.0.1
echo   DB_PORT=3306
echo   DB_DATABASE=couponsite
echo   DB_USERNAME=root
echo   DB_PASSWORD=your_password
echo.
pause

echo.
echo [3/5] Generating application key...
call php artisan key:generate --ansi
if %ERRORLEVEL% neq 0 ( echo ERROR: key:generate failed & pause & exit /b 1 )

echo.
echo [4/5] Running database migrations...
echo Make sure the MySQL database "couponsite" exists before continuing.
echo You can create it with: CREATE DATABASE couponsite;
echo.
pause
call php artisan migrate --force
if %ERRORLEVEL% neq 0 ( echo ERROR: migrate failed & pause & exit /b 1 )

echo.
echo [5/5] Seeding database with sample data...
call php artisan db:seed --force
if %ERRORLEVEL% neq 0 ( echo ERROR: db:seed failed & pause & exit /b 1 )

echo.
echo ============================================
echo  Setup complete! Starting dev server...
echo  Visit: http://127.0.0.1:8000/store/ifunds
echo ============================================
echo.
call php artisan serve
