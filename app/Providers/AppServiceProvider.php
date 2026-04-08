<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // AppServiceProvider.php

        foreach (glob(base_path('modules/*'), GLOB_ONLYDIR) as $modulePath) {
            $provider = $modulePath . '/' . basename($modulePath) . 'ServiceProvider.php';
            if (file_exists($provider)) {
                $namespace = 'Modules\\' . basename($modulePath) . '\\' . basename($modulePath) . 'ServiceProvider';
                $this->app->register($namespace);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
