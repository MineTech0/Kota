#!/bin/sh
set -e
 
echo "Deploying application ..."
 
# Enter maintenance mode
(php artisan down) || true
    # Update codebase
    git fetch origin deploy
    git reset --hard origin/deploy
 
    # Install dependencies based on lock file
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
 
    # Migrate database
    php artisan migrate --force
 
    # Clear cache
    php artisan optimize
 
# Exit maintenance mode
php artisan up
 
echo "Application deployed!"