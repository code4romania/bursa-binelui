#!/command/with-contenv sh

cd /var/www

php artisan migrate --force
php artisan storage:link

php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
php artisan icons:cache

if [ -n "${PRELAUNCH_SECRET}" ]; then
    php artisan down \
        --secret="$PRELAUNCH_SECRET" \
        --render="prelaunch" \
        --status="200"
fi

php artisan about
