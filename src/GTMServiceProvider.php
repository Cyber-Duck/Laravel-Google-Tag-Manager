<?php
namespace CyberDuck\LaravelGoogleTagManager;

use Illuminate\Support\ServiceProvider;
use Blade;

class GTMServiceProvider extends ServiceProvider
{
    /**
     * Initialise the Google Tag Manager plugin
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'tracking');

        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('gtm.php')
        ]);

        view()->composer('tracking::*', function ($view) {
             $view->with('GTM', $this->app[GTM::class]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GTM::class, function ($app) {
            return new GTM();
        });
    }
}
