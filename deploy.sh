#!/bin/bash
set -e

# Update code
if [ ! -d ".git" ]; then
    git clone -b prod https://github.com/fedrianMF/portfolio-saas.git .
else
    git fetch origin prod
    git reset --hard origin/prod
fi

# Infrastructure
docker compose -f docker-compose.prod.yml up -d --build

# Permissions
docker exec -u root saas_app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker exec -u root saas_app chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Database & Metadata
docker exec saas_app php artisan queue:failed-table || true
docker exec saas_app php artisan cache:table || true
docker exec saas_app php artisan migrate --force

# App Optimization & Supervisor
docker exec saas_app php artisan config:cache
docker exec saas_app supervisorctl reread
docker exec saas_app supervisorctl update
docker exec saas_app supervisorctl restart all

docker image prune -f