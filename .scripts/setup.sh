#!/bin/sh
set -e
 
echo "Setting up application ..."
 
    # Update codebase
    git fetch origin deploy
    git reset --hard origin/deploy
 
    # Install dependencies based on lock file
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
 
    # Migrate database
    php artisan migrate --force
 
    # Clear cache
    php artisan config:cache

    php artisan event:cache

    php artisan route:cache

    php artisan view:cache

    #link storage
    php artisan storage:link
 
# Exit maintenance mode
php artisan up
 
echo "Application deployed!"