# gmj-laravel_block2_banner

Laravel Block for backend and frontend - need tailwindcss support

**composer require gmj/laravel_block2_banner**

in terminal run:<br/>
php artisan vendor:publish --provider="GMJ\LaravelBlock2Banner\LaravelBlock2BannerServiceProvider" --force

php artisan migrate

php artisan db:seed --class=LaravelBlock2BannerSeeder

package for test<br>
composer.json#autoload-dev#psr-4: "GMJ\\LaravelBlock2Banner\\": "package/laravel_block2_banner/src/",<br>
config: GMJ\LaravelBlock2Banner\LaravelBlock2BannerServiceProvider::class,
