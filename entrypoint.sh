#!/bin/sh
set -e

# Crée les dossiers nécessaires
mkdir -p /var/www/var/cache /var/www/var/log

# Met les bonnes permissions (pour dev)
chown -R www-data:www-data /var/www/var
chmod -R 775 /var/www/var

# Lance PHP-FPM
php-fpm
