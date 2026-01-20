#!/bin/bash
set -e

# Build and start containers
# We use -f to specify the production file explicitly
docker compose -f docker-compose.prod.yml up -d --build

# Fix permissions for storage and bootstrap (Required for Laravel logs)
docker exec -u root saas_app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker exec -u root saas_app chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Database migrations and metadata tables
# || true ensures the script continues if tables already exist
docker exec saas_app php artisan queue:failed-table || true
docker exec saas_app php artisan cache:table || true
docker exec saas_app php artisan migrate --force

# App Optimization
docker exec saas_app php artisan config:cache
docker exec saas_app php artisan route:cache

# Restart Supervisor workers
docker exec saas_app supervisorctl reread
docker exec saas_app supervisorctl update
docker exec saas_app supervisorctl restart all

# Cleanup old images
docker image prune -f