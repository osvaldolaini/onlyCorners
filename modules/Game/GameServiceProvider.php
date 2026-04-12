<?php

namespace Modules\Game;

use Illuminate\Support\ServiceProvider;

class GameServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', strtolower('Game'));
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register(): void
    {
        //
    }
}