<?php
namespace CyberDuck\LaravelGoogleTagManager\Facades;

use Illuminate\Support\Facades\Facade;

class GTM extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cyberduck.gtm';
    }
}
