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

Add the following to the list of service providers in your config/app.php file

```php
'CyberDuck\LaravelGoogleTagManager\GTMServiceProvider',

```

Add the following alias to your config/app.php file

```php
'GTM' => 'CyberDuck\LaravelGoogleTagManager\Facades\GTM',
```

Copy the config files by running:

```php
php artisan vendor:publish
```

Configure your GTM-XXXXX ID in config/gtm.php


# Usage

Within your main blade layout template include the GTM blade template

```php
@include('tracking.gtm')
```

## Push additional data
```php
\GTM::data('paramName', 'paramValue')
```

## Push an event
```php
\GTM::data('eventName')
```
