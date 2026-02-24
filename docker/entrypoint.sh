#!/bin/sh

# 1. Start the Cron daemon (crond)
# -f: runs in background, -l 2: low log level
crond -l 2 -b

# 2. Start Supervisor (workers of queues) in background
/usr/bin/supervisord -c /etc/supervisor/conf.d/laravel-worker.conf &

# 3. Start PHP-FPM in foreground (keeps the container alive)
echo "PHP-FPM starting..."
exec php-fpm
