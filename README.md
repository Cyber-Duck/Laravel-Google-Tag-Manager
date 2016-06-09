# Laravel Google Tag Manager

Google tag manager features including events, ecommerce, and dataLayer support

Author: [Andrew Mc Cormack](https://github.com/Andrew-Mc-Cormack)

# Installation

## Composer

Add the following to your composer.json file

```json
{  
    "require": {  
        "cyber-duck/laravel-google-tag-manager": "1.0.*"
    },  
    "repositories": [  
        {  
            "type": "vcs",  
            "url": "https://github.com/cyber-duck/laravel-google-tag-manager"  
        }  
    ]  
}
```

## Framework

Create the TagManagerServiceProvider with the artisan CLI command:

```
php artisan make:provider TagManagerServiceProvider
```

Within the boot function of the service provider add your GTM-XXXXX ID.

```php
namespace {YourApp}\Providers;

use {YourApp}\Support\ServiceProvider;
use GTM;

class TagManagerServiceProvider extends ServiceProvider
{
    /**
     * Initialise the Google Tag Manager plugin
     *
     * @return void
     */
    public function boot(GTM $gtm)
    {
        $gtm->id('XXXXX');

        $this->publishes([
            base_path('vendor/cyber-duck/laravel-google-tag-manager/views') => base_path('resources/views/tracking'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
```

Add the following to the list of service providers in your config/app.php file

```php
'{YourApp}\Providers\TagManagerServiceProvider',

```

Add the following alias to your config/app.php file

```php
'GTM' => 'CyberDuck\LaravelGoogleTagManager\GTM',
```

Copy the template files from the vendor folder to your resources/views folder by running:

```php
php artisan vendor:publish
```

Within your main blade layout template include the GTM blade template

```php
@include('tracking.gtm')
```