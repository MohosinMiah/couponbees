#!/bin/bash
set -e

echo "============================================"
echo " CouponHub - Auto Setup Script (Linux/Mac)"
echo " Database: MySQL - couponsite"
echo "============================================"

echo ""
echo "[1/5] Installing Composer dependencies..."
# composer install --no-interaction

echo ""
echo "[2/5] Copying .env file..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env created."
else
    echo ".env already exists, skipping."
fi

echo ""
echo "[3/5] Generating application key..."
php artisan key:generate --ansi

echo ""
echo "[4/5] Running database migrations..."
echo "Make sure MySQL is running and the 'couponsite' database exists."
echo "Create it with: mysql -u root -p -e \"CREATE DATABASE couponsite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\""
echo ""
php artisan migrate --force

echo ""
echo "[5/5] Seeding database with sample data..."
php artisan db:seed --force

echo ""
echo "============================================"
echo " Setup complete! Starting dev server..."
echo " Visit: http://127.0.0.1:8000/store/ifunds"
echo "============================================"
echo ""
php artisan serve
