@echo off

echo Installing dependencies via composer
composer update

echo Migrating table changes to database timelog
php artisan migrate

echo Running database seeder
php artisan db:seed