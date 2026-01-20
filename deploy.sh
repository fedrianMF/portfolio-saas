#!/bin/bash
set -e

# 1. Fix ownership so Git can update files
# This ensures your user owns the files, not the Docker root user
sudo chown -R $USER:$USER .

# 2. Detect current branch
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
echo "🌿 Current branch detected: $CURRENT_BRANCH"

# 3. Update code
echo "Updating code from origin/$CURRENT_BRANCH..."
git fetch origin $CURRENT_BRANCH
git reset --hard origin/$CURRENT_BRANCH

# 4. Infrastructure
docker compose -f docker-compose.prod.yml up -d --build

# 5. Restore Permissions for Laravel (Docker side)
echo "🔐 Restoring Laravel storage permissions..."
docker exec -u root saas_app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker exec -u root saas_app chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# 6. Database & Metadata
docker exec saas_app php artisan queue:failed-table || true
docker exec saas_app php artisan cache:table || true
docker exec saas_app php artisan migrate --force

# 7. App Optimization & Supervisor
docker exec saas_app php artisan config:cache
docker exec saas_app supervisorctl reread
docker exec saas_app supervisorctl update
docker exec saas_app supervisorctl restart all

docker image prune -f
echo "✅ Deployment of branch '$CURRENT_BRANCH' finished successfully!"