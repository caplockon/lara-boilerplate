#!/usr/bin/env bash


# Enable cronjob
crontab /etc/cron.d/cronjob

php artisan cache:clear

chmod -R 777 /var/www/html/storage

# Supervisor
service supervisor force-reload

service supervisor start app-worker:*

# Check and run migration if not production
echo "--- Checking environment to run migration --- "
echo "--- Set env: $APP_ENV ---"
if [ "$APP_ENV" != "production" ]; then
    php artisan migrate
fi

apache2-foreground
