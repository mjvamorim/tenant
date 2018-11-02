This package provider a database tenant soluction which database connection is choice based on company/user select on login;

composer require mjvamorim/tenant
composer update

php artisan config:cache
php artisan vendor:publish --provider="Amorim\Tenant\TenantServiceProvider"

Edit "/config/tenant.php" and put your database conections defaults.

php artisan db:seed --class="Amorim\Tenant\Database\Seeds\TenantSeeder"
