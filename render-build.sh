#!/usr/bin/env bash
# Render build script for Yuasa Fleet (Laravel 12)
set -e

echo "==> Installing PHP dependencies..."
composer install --optimize-autoloader --no-dev

echo "==> Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "==> Creating storage link..."
php artisan storage:link || true

echo "==> Running database migrations..."
php artisan migrate --force

echo "==> Seeding database..."
php artisan db:seed --force

echo "==> Caching config for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Build complete!"
