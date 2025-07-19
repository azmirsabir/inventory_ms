composer install

#cp .env.example .env

#php artisan migrate:fresh --seed
#php artisan migrate

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize:clear
php artisan optimize
php artisan config:cache
php artisan storage:link

chown -R apache:apache storage
