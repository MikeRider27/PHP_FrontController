#!/bin/sh
set -e

if [ -f /var/www/html/composer.json ] && [ ! -d /var/www/html/vendor ]; then
    composer install --working-dir=/var/www/html --no-interaction --optimize-autoloader
fi

exec docker-php-entrypoint "$@"
