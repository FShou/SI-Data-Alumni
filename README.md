# Initialize
- Edit .env
- Run this command
```sh
composer install
npm install
php artisan migrate --seed
php artisan storage:link
```
# Running
- keep this running
```sh
php artisan serve
npm run dev
```
