<?php

namespace GMJ\LaravelBlock2Banner;

use GMJ\LaravelBlock2Banner\View\Components\Frontend;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelBlock2BannerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadRoutesFrom(__DIR__ . "/routes/web.php", 'LaravelBlock2Banner');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'LaravelBlock2Banner');
        $this->loadViewsFrom(__DIR__ . '/resources/views/config', 'LaravelBlock2Banner.config');

        Blade::component("LaravelBlock2Banner", Frontend::class);

        $this->publishes([
            __DIR__ . "/config/laravel_block2_banner_config.php" => config_path("gmj/laravel_block2_banner_config.php"),
            __DIR__ . '/database/seeders' => database_path('seeders'),
        ], 'GMJ\LaravelBlock2Banner');
    }


    public function register()
    {
    }
}
