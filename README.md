# Laravel Share Buttons ![test workflow](https://github.com/kudashevs/laravel-share-buttons/actions/workflows/run-tests.yml/badge.svg)

This Laravel Share Buttons package was originated from [Laravel Share](https://github.com/jorenvh/laravel-share) package.  
The package gives you the possibility to create share buttons for your site in a flexible and convenient way.

[//]: # (@todo don't forget to update these services)
### Available services

* Facebook
* LinkedIn
* Pinterest
* Reddit
* Telegram
* Twitter
* VKontakte
* WhatsApp
* Copy link

## Installation

You can install the package via composer:

``` bash
composer require kudashevs/laravel-share-buttons
```

If you don't use auto-discovery just add a ServiceProvider to the config/app.php

```php
'providers' => [
    Kudashevs\ShareButtons\Providers\ShareButtonsServiceProvider::class,
];
```

If you want to add a Laravel Facade just add it in the config/app.php

```php
'aliases' => [
    'Share' => Kudashevs\ShareButtons\Facades\ShareButtonsFacade::class,
];
```

Publish the package config and resource files. You might need to republish the config after major changes in the package.
In the case of major changes, it is recommended to backup your config file somewhere and republish a new one from scratch.

```bash
php artisan vendor:publish --provider="Kudashevs\ShareButtons\Providers\ShareButtonsServiceProvider"
```

This command will create three different files:
```
config/share-buttons.php                     # A configuration file
resources/lang/vendor/en/share-buttons.php   # A visual representation of elements
resources/assets/js/share-buttons.js         # A javascript (jQuery) file
```

### Font Awesome

This package relies on Font Awesome, so you have to use it in your app. However, you can easily integrate any fonts, CSS, or JS.
For further information on how to use Font Awesome please read the [introduction](https://fontawesome.io/get-started/).

### Javascript

To have javascript you need to load the jQuery library and integrate resources/assets/js/share-buttons.js into your
template eco-system. One of the ways of doing it is to copy this file to public/js folder and use it like in the example
below, or to add this file into your assets compiling flow.

```html
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script src="{{ asset('js/share-buttons.js') }}"></script>
```

## Usage

The package is really easy to use and provides a fluent interface to build the share buttons code. You can use a couple
of methods to start a method chaining. They are:

```
page($url, $title = '', $options = [])
createForPage($url, $title = '', $options = [])
createForCurrentPage($title = '', $options = [])
```

### Share a specific page

``` php
ShareButtons::page('https://jorenvanhocht.be')->facebook();
ShareButtons::page('https://jorenvanhocht.be', 'Your share text here')->twitter();
ShareButtons::createForPage('https://jorenvanhocht.be')->facebook();
ShareButtons::createForPage('https://jorenvanhocht.be', 'Your share text here')->twitter();
```

### Share a current page

```php
ShareButtons::currentPage()->facebook();
ShareButtons::page('https://jorenvanhocht.be', 'Your share text here')->twitter();
```

### Creating multiple share Links

The usual way of using the share buttons package is to create multiple links. You just need to chain the methods for this.

```php
ShareButtons::page('https://jorenvanhocht.be', 'Share title')
    ->facebook()
    ->twitter()
    ->linkedin(['summary' => 'Extra linkedin summary can be passed here'])
    ->whatsapp();
```

This will generate the following HTML code

```html
<div id="social-links">
    <ul>
        <li><a href="https://www.facebook.com/sharer/sharer.php?u=https://jorenvanhocht.be" class="social-button"><span class="fa fa-facebook-square"></span></a></li>
        <li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url=https://jorenvanhocht.be" class="social-button"><span class="fa fa-twitter"></span></a></li>
        <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=https://jorenvanhocht.be&amp;title=my share text&amp;summary=dit is de linkedin summary" class="social-button"><span class="fa fa-linkedin"></span></a></li>
        <li><a href="https://wa.me/?text=https://jorenvanhocht.be" class="social-button"><span class="fa fa-whatsapp"></span></a></li>    
    </ul>
</div>
```

### Getting the result

You can just use the object as a string or cast it to string to get the share buttons code. However, it is not a perfect
way of using it. If you want to be precise and clear with your code intentions use the ```getShareButtons``` method.

```php
ShareButtons::page('https://jorenvanhocht.be', 'Share title')
    ->facebook()
    ->getShareButtons();
```

### Getting the raw links

In some cases, you may only need the raw links without any HTML. In such a case use the `getRawLinks` method.

```php
ShareButtons::page('https://jorenvanhocht.be', 'Share title')
    ->facebook()
    ->getRawLinks();
```

## Optional parameters

### Add extra options to your buttons

The package allows you to provide additional options to the share buttons code. It can be made globally (by providing options
to the fluent interface start method), and locally (by providing options to the specific method).

At the moment, the package supports the following options:

### Global options

```
'block_prefix' => 'value'       # Set up a block prefix, e.g. <ul>
'block_suffix' => 'value'       # Set up a block prefix, e.g. </ul>
'element_prefix' => 'value'     # Set up an element prefix, e.g. <li>
'element_suffix' => 'value'     # Set up an element suffix, e.g. </li>
'id' => 'value'                 # Add an id attribute to a link
'class' => 'value'              # Add a class attribute to a link
'title' => 'value'              # Add a title attribute to a link
'rel' => 'value'                # Add a rel attribute to a link
```

### Local options

```
'id' => 'value'                 # Add an id attribute to a link
'class' => 'value'              # Add a class attribute to a link
'title' => 'value'              # Add a title attribute to a link
'rel' => 'value'                # Add a rel attribute to a link
'summary' => 'value'            # Only used with a linkedin provider (special case)
```

#### Usage examples

```php
ShareButtons::page('https://jorenvanhocht.be', '', [
        'block_prefix' => '<ul>',
        'block_suffix' => '</ul>',
        'class' => 'my-class',
        'id' => 'my-id',
        'title' => 'my-title',
        'rel' => 'nofollow noopener noreferrer',
    ])
    ->facebook();
```

will result into the following HTML code

```html
<ul>
    <li><a href="https://www.facebook.com/sharer/sharer.php?u=https://jorenvanhocht.be" class="social-button my-class" id="my-id" title="my-title" rel="nofollow noopener noreferrer"><span class="fab fa-facebook-square"></span></a></li>
</ul>
```

```php
ShareButtons::page('https://jorenvanhocht.be', '', [
        'block_prefix' => '<ul>',
        'block_suffix' => '</ul>',
        'class' => 'my-class',
        'id' => 'my-id',
        'title' => 'my-title',
        'rel' => 'nofollow noopener noreferrer',
    ])
    ->facebook()
    ->linkedin(['id' => 'linked', 'class' => 'hover', 'rel' => 'follow', 'summary' => 'cool summary']);
```

will result into the following HTML code

```html
<ul>
    <li><a href="https://www.facebook.com/sharer/sharer.php?u=https://jorenvanhocht.be" class="social-button my-class" id="my-id" title="my-title" rel="nofollow noopener noreferrer"><span class="fab fa-facebook-square"></span></a></li>
    <li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://jorenvanhocht.be&title=Default+share+text&summary=cool+summary" class="social-button hover" id="linked" title="my-title" rel="follow"><span class="fab fa-linkedin"></span></a></li>
</ul>
```

## Configuration

The package comes with some configuration settings. These are:

### Providers section

Each share provider has specific settings that can be configured. 

```
'url' => 'value'                # A share url which is used by a provider
'text' => 'value'               # A text which is used when page title is not set
'extra' => []                   # Extra options which are required by the specific providers
```

### Font Awesome setting

```
'fontAwesomeVersion' => number  # Specify a Font Awesome version to use
```

### Formatting elements section

```
'block_prefix' => 'value'       # Set up a block prefix, e.g. <ul>
'block_suffix' => 'value'       # Set up a block prefix, e.g. </ul>
'element_prefix' => 'value'     # Set up an element prefix, e.g. <li>
'element_suffix' => 'value'     # Set up an element suffix, e.g. </li>
```

### React on errors section

```
'reactOnErrors' => bool         # Specify whether it throws exceptions on unexpected methods or not
'throwException' => FQCN        # Specify the exception to throw (should be in the context-independent FQCN format)
```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
