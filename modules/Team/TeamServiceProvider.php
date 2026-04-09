<?php

namespace Modules\Team;

use Illuminate\Support\ServiceProvider;

class TeamServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', strtolower('Team'));
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register(): void
    {
        //
    }
}