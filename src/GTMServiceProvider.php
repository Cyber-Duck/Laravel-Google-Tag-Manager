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
        $this->addDirectives();

        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('gtm.php')
        ], 'config');

        view()->composer('tracking::*', function ($view) {
             $view->with('GTM', $this->app['cyberduck.gtm']);
        });
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

    public function addDirectives()
    {
        Blade::directive('gtmClick', function($product) {
            if ($product instanceof Product/IsShoppable) {
                $product = $product->getShoppableData();
            }
            $bladeBit = "<?php echo 'data-product-gtm=\"";
            $bladeBit .= json_encode($product);
            $bladeBit .= "\" onclick=\"gtmClick()\"'; ?>";
        });
    }
}