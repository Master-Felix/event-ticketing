#!/bin/bash
# Install dependencies
composer install --no-dev --optimize-autoloader

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
    # Generate application key if needed
    # php artisan key:generate
fi

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
