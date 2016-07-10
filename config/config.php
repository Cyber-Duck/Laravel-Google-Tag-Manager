<?php
return [
    /*
     * Google Tag Manager id.
     */
    'id' => env('GTM_ID', 'XXXXX'),

    /*
     * Enable or disable GTM. (Set to false in your local environment)
     */
    'enabled' => env('GTM_ENABLED', true),

    /*
     * The key where your session data will have been saved.
     */
    'sessionKey' => 'cyberduck.gtm',

    'ecommerce' => [
        /*
         * The default currency.
         */
        'currency' => 'GBP',
    ],
];
