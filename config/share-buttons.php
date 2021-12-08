<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Providers
    |--------------------------------------------------------------------------
    |
    | This value specifies basic settings for share providers.
    | They include a share url, default share text, some extras.
    |
    |
    */

    'providers' => [
        'facebook' => [
            'url' => 'https://www.facebook.com/sharer/sharer.php?u=',
        ],
        'twitter' => [
            'url' => 'https://twitter.com/intent/tweet',
            'text' => 'Default share text',
        ],
        'linkedin' => [
            'url' => 'https://www.linkedin.com/sharing/share-offsite',
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
    | Font Awesome version
    |--------------------------------------------------------------------------
    |
    | This value specifies the version of Font Awesome which is going to be used.
    | At the moment the package supports version 5 (default value).
    |
    |
    */

    'fontAwesomeVersion' => 5,

    /*
    |--------------------------------------------------------------------------
    | Formatting elements
    |--------------------------------------------------------------------------
    |
    | These values specify a share buttons representation. Here we can specify:
    |
    | - block wrapper (block_prefix starts a block, block_suffix ends a block)
    | - element wrapper (element_prefix starts an element, element_suffix ends
    |   an element)
    |
    */

    'block_prefix' => '<div id="social-links"><ul>',
    'block_suffix' => '</ul></div>',
    'element_prefix' => '<li>',
    'element_suffix' => '</li>',

];
