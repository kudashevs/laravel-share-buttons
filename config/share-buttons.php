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
        'copylink' => [
            'url' => ':url',
            'extra' => ['hash' => 'true'],
        ],
        'facebook' => [
            'url' => 'https://www.facebook.com/sharer/sharer.php?u=:url',
        ],
        'linkedin' => [
            'url' => 'https://www.linkedin.com/sharing/share-offsite?mini=:mini&url=:url&title=:title&summary=:summary',
            'text' => 'Default share text',
            'extra' => [
                'mini' => 'true',
                'summary' => '',
            ],
        ],
        'pinterest' => [
            'url' => 'https://pinterest.com/pin/create/button/?url=:url',
        ],
        'reddit' => [
            'url' => 'https://www.reddit.com/submit?title=:title&url=:url',
            'text' => 'Default share text',
        ],
        'telegram' => [
            'url' => 'https://telegram.me/share/url?url=:url&text=:title',
            'text' => 'Default share text',
        ],
        'twitter' => [
            'url' => 'https://twitter.com/intent/tweet',
            'text' => 'Default share text',
        ],
        'vkontakte' => [
            'url' => 'https://vk.com/share.php',
            'text' => 'Default share text',
        ],
        'whatsapp' => [
            'url' => 'https://wa.me/',
            'extra' => ['mini' => 'true'],
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

    /*
    |--------------------------------------------------------------------------
    | React on errors
    |--------------------------------------------------------------------------
    |
    | This package uses a magic __call() method in its core. Despite the fact
    | that this solution works pretty fine, it can lead to hard to find errors.
    | If you want to be aware of all the unexpected calls on the __call() method,
    | set the below option "reactOnErrors" to `true`. If not, set it to `false`.
    |
    */

    'reactOnErrors' => true,
    'throwException' => \Error::class,

];
