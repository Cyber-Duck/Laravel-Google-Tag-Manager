<?php
namespace CyberDuck\LaravelGoogleTagManager;

use Illuminate\Support\ServiceProvider;

class GTMServiceProvider extends ServiceProvider
{
    /**
     * Initialise the Google Tag Manager plugin
     *
     * @return void
     */
    public function boot(GTM $gtm)
    {
        $gtm->id(config('gtm.id'));

        $this->publishes([
            base_path('vendor/cyber-duck/laravel-google-tag-manager/views') => base_path('resources/views/tracking'),
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
        $this->app->singleton('cyberduck.gtml', function ($app) {
            return new GTM();
        });
    }
}
