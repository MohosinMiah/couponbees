# CouponHub - Laravel Coupon Website

Built with **Laravel 11**, **Bootstrap 5**, HTML & CSS.
**Database: MySQL (`couponsite`)**
---

## Git Setup
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

php composer.phar install

## Admin
Username: cb_admin_5ggx77
Password: 8P%yVyQ*8ADMt4X7VpYf

## ⚡ Setup Steps

### Step 1 — Create MySQL Database

Run this in MySQL / phpMyAdmin / HeidiSQL:
```sql
CREATE DATABASE couponsite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 2 — Install & Configure

```bat
composer install
copy .env.example .env
```

Open `.env` and set your MySQL password:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=couponsite
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### Step 3 — Run Migrations & Seed

```bat
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

Visit: **http://127.0.0.1:8000/store/ifunds**

---

## Or use setup.bat (Windows)

Just run:
```
setup.bat
```

---

## Common Errors & Fixes

| Error | Fix |
|-------|-----|
| `Access denied for user` | Set correct `DB_USERNAME` / `DB_PASSWORD` in `.env` |
| `Unknown database 'couponsite'` | Run `CREATE DATABASE couponsite;` in MySQL first |
| `no such table: stores` | Run `php artisan migrate` then `php artisan db:seed` |
| `APP_KEY` not set | Run `php artisan key:generate` |

---

## Routes

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/` | All stores (home) |
| GET | `/stores` | Stores listing |
| GET | `/store/{slug}` | Store coupon page |
| POST | `/coupon/{id}/copy` | AJAX: record copy |
| POST | `/coupon/{id}/feedback` | AJAX: success/failure |

---

## Project Structure

```
app/Http/Controllers/
    StoreController.php
    CouponController.php
app/Models/
    Store.php  /  Coupon.php  /  CouponHistory.php
database/migrations/     (3 files — stores, coupons, coupon_histories)
database/seeders/        (5 stores + 6 iFunds coupons)
resources/views/
    layouts/app.blade.php
    stores/show.blade.php
    stores/index.blade.php
public/css/app.css
routes/web.php
```
