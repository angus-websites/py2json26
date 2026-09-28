#!/bin/sh

# Run our artisan commands
php artisan route:clear
php artisan config:clear
php artisan view:clear

# Clear version cache
php artisan app:clear-version-cache

echo "Starting worker Supervisor..."
# Start Supervisor in the background
supervisord -c /etc/supervisord.conf &

echo "Starting Octane with FrankenPHP..."
php artisan octane:frankenphp
