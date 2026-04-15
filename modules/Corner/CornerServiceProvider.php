<?php

namespace Modules\Corner;

use Illuminate\Support\ServiceProvider;

class CornerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', strtolower('Corner'));
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register(): void
    {
        //
    }
}