<?php

namespace Modules\Championship;

use Illuminate\Support\ServiceProvider;

class ChampionshipServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', strtolower('Championship'));
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register(): void
    {
        //
    }
}