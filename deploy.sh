#!/bin/bash

cd /var/www/early-breast-diagnosis || exit
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
systemctl reload nginx
echo "✅ Deployment completed at $(date)"
