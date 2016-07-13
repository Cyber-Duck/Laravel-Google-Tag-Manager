# Laravel Google Tag Manager
[![Latest Stable Version](https://poser.pugx.org/cyber-duck/laravel-google-tag-manager/v/stable)](https://packagist.org/packages/cyber-duck/laravel-google-tag-manager)
[![Total Downloads](https://poser.pugx.org/cyber-duck/laravel-google-tag-manager/downloads)](https://packagist.org/packages/cyber-duck/laravel-google-tag-manager)
[![License](https://poser.pugx.org/cyber-duck/laravel-google-tag-manager/license)](https://packagist.org/packages/cyber-duck/laravel-google-tag-manager)

Google tag manager features including events, ecommerce, and dataLayer support

Authors: [Andrew Mc Cormack](https://github.com/Andrew-Mc-Cormack), [Simone Todaro](https://github.com/SimoTod)

# Installation

## Composer

Require this package with composer:

```
composer require cyber-duck/laravel-google-tag-manager
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
php artisan vendor:publish --provider="CyberDuck\LaravelGoogleTagManager\GTMServiceProvider"
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
