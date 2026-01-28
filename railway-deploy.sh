#!/bin/bash

# Create SQLite database file
touch database/database.sqlite

# Run migrations
php artisan migrate --force --no-interaction

# Seed the database with demo data
php artisan db:seed --force --no-interaction

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployment setup complete!"
