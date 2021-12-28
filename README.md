# gmj-laravelblock2banner

Laravel Block for backend and frontend - need tailwindcss support

composer require gmj/laravel_block2_banner_content

in terminal run: php artisan vendor:publish --provider="GMJ\LaravelBlock2Banner\LaravelBlock2BannerServiceProvider" --force

php artisan migrate

php artisan db:seed --class=LaravelBlock2BannerSeeder
