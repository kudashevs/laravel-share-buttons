<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    |
    | Specify the base uri for each service.
    |
    |
    |
    */

    'services' => [
        'facebook' => [
            'url' => 'https://www.facebook.com/sharer/sharer.php?u=',
        ],
        'twitter' => [
            'url' => 'https://twitter.com/intent/tweet',
            'text' => 'Default share text',
        ],
        'linkedin' => [
            'url' => 'https://www.linkedin.com/sharing/share-offsite',
            'text' => 'Default share text',
            'extra' => ['mini' => 'true'],
        ],
        'whatsapp' => [
            'url' => 'https://wa.me/?text=',
            'extra' => ['mini' => 'true'],
        ],
        'pinterest' => [
            'url' => 'https://pinterest.com/pin/create/button/?url=',
        ],
        'reddit' => [
            'url' => 'https://www.reddit.com/submit',
            'text' => 'Default share text',
        ],
        'telegram' => [
            'url' => 'https://telegram.me/share/url',
            'text' => 'Default share text',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Font Awesome
    |--------------------------------------------------------------------------
    |
    | Specify the version of Font Awesome that you want to use.
    | We support version 4 and 5.
    |
    |
    */

    'fontAwesomeVersion' => 5,
];
