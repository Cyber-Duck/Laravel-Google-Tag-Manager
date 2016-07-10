# Laravel Google Tag Manager

Google tag manager features including events, ecommerce, and dataLayer support

Authors: [Andrew Mc Cormack](https://github.com/Andrew-Mc-Cormack), [Simone Todaro](https://github.com/SimoTod)

# Installation

## Composer

Add the following to your composer.json file

```json
{
    "require": {
        "cyber-duck/laravel-google-tag-manager": "1.1.*"
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

Add the following to the list of service providers in your config/app.php file

```php
'CyberDuck\LaravelGoogleTagManager\GTMServiceProvider',

```

Add the following alias to your config/app.php file

```php
'GTM' => 'CyberDuck\LaravelGoogleTagManager\Facades\GTM',
```

Publish configuration and view files:

```php
php artisan vendor:publish --provider="Cyberduck\LaravelGoogleTagManager\GTMServiceProvider"
```

Configure your GTM-XXXXX ID in config/gtm.php


# Usage

Within your main blade layout template include the GTM blade template

```php
@include('tracking::gtm')
```

## Pushing additional data
```php
\GTM::data('paramName', 'paramValue')
```

## Pushing an event
```php
\GTM::event('eventName')
```

## Flashing data for the next request
```php
\GTM::flash()
return redirect()->action('...');
```
