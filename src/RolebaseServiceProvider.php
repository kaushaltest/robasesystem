<?php

namespace Role\Rolebasesystem;

use Illuminate\Support\ServiceProvider;

class RolebaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'rolebasesystem');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/rolebasesystem'),
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers/role/rolebasesystem'),
            __DIR__.'/Models' => app_path('Models/role/rolebasesystem'),
        ],'rolebasesystem');
    }
    public function register()
    {
    }
}
