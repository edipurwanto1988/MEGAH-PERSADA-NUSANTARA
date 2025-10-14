#!/bin/bash

echo "Starting Laravel deployment script..."

# Run composer install
echo "Installing composer dependencies..."
composer install --optimize-autoloader --no-dev

# Run npm install and build assets
echo "Installing npm dependencies and building assets..."
npm install
npm run build

# Create storage link if it doesn't exist
echo "Creating storage link..."
if [ ! -L "public/storage" ]; then
    php artisan storage:link
fi

# Cache configuration and routes for production
echo "Caching configuration and routes..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "Setting proper permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "Deployment completed successfully!"