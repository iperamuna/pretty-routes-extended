<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pretty Routes URL
    |--------------------------------------------------------------------------
    |
    | This value determines the endpoint where the pretty routes interface
    | will be accessible. By default, it is set to 'routes'.
    |
    */

    'url' => env('PRETTY_ROUTES_URL', 'routes'),

    /*
    |--------------------------------------------------------------------------
    | Middlewares
    |--------------------------------------------------------------------------
    |
    | These middlewares will be applied to the pretty routes page. You should
    | ensure that at least the 'web' middleware is applied to manage sessions
    | and CSRF protection if applicable.
    |
    */

    'middlewares' => [
        'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Only
    |--------------------------------------------------------------------------
    |
    | When set to true, the pretty routes page will only be accessible when
    | the application is in debug mode (APP_DEBUG=true).
    |
    */

    'debug_only' => env('PRETTY_ROUTES_DEBUG_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | Hidden Methods
    |--------------------------------------------------------------------------
    |
    | Here you may specify the HTTP methods that should be hidden from the
    | route list. By default, 'HEAD' requests are hidden.
    |
    */

    'hide_methods' => [
        'HEAD',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hidden Routes (Regex)
    |--------------------------------------------------------------------------
    |
    | You may specify regular expressions for URIs that should be hidden
    | from the routes list. This is useful for hiding internal routes.
    |
    */

    'hide_matching' => [
        '#^_debugbar#',
        '#^_ignition#',
        '#^routes$#',
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation Settings
    |--------------------------------------------------------------------------
    |
    | The 'back_to_system_url' allows you to define a link to return to your
    | main administration panel. The 'back_to_system_label' is the text
    | displayed for this link.
    |
    */

    'back_to_system_url' => env('PRETTY_ROUTES_BACK_URL', config('app.url').'/sadmin'),

    'back_to_system_label' => env('PRETTY_ROUTES_BACK_LABEL', 'Back to SAdmin Panel'),

    /*
    |--------------------------------------------------------------------------
    | Footer Attribution
    |--------------------------------------------------------------------------
    |
    | When enabled, a subtle attribution to the package will be displayed
    | in the sticky footer of the routes interface.
    |
    */

    'show_footer_attribution' => env('PRETTY_ROUTES_SHOW_ATTRIBUTION', true),

];
