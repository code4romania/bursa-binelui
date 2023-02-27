#!/command/with-contenv sh

cd /var/www

# @TODO: save secrets in .env.prod.local or .env.local

composer dump-env prod
composer auto-scripts
php bin/console sulu:build dev --no-interaction
