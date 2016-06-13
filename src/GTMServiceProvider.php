<?php
namespace CyberDuck\LaravelGoogleTagManager;

use Illuminate\Support\ServiceProvider;
use View;

class GTMServiceProvider extends ServiceProvider
{
    /**
     * Initialise the Google Tag Manager plugin
     *
     * @return void
     */
    public function boot()
    {
        $this->app['cyberduck.gtm']->id(config('gtm.id'));
        View::share('GTM', $this->app['cyberduck.gtm']);

        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/tracking')
        ]);

        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('gtm.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cyberduck.gtm', function ($app) {
            return new GTM();
        });
    }
}
