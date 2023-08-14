# Laravel Share Buttons ![test workflow](https://github.com/kudashevs/laravel-share-buttons/actions/workflows/run-tests.yml/badge.svg)

The Laravel Share Buttons package was originated from [Laravel Share](https://github.com/jorenvh/laravel-share). This package
provides the possibility to create a block of social media share buttons for your site in a flexible and convenient way.

[//]: # (@todo don't forget to update these services)
### Available services

* Facebook
* Twitter
* LinkedIn
* Telegram
* WhatsApp
* Reddit
* Hacker News
* VKontakte
* Pinterest
* Pocket
* Evernote
* Skype
* Xing
* Copy the link
* Mail the link

## Installation

You can install the package via composer:
```bash
composer require kudashevs/laravel-share-buttons
```

If you don't use auto-discovery just add a ShareButtonsServiceProvider to the `config/app.php`
```php
'providers' => [
    Kudashevs\ShareButtons\Providers\ShareButtonsServiceProvider::class,
];
```

If you want to add a Laravel Facade just add a ShareButtonsFacade to the `config/app.php`
```php
'aliases' => [
    'ShareButtons' => Kudashevs\ShareButtons\Facades\ShareButtonsFacade::class,
];
```
by default, the `ShareButtons` class instance is bound to the `sharebuttons` alias.

<a id="publish"></a>**Don't forget** to publish a configuration file and assets. If you want to limit the type of assets,
you can use the `--tag` option with one of the following tags: `config`, `js` (all js files), `vanilla`, `jquery`, `css`.
```bash
php artisan vendor:publish --provider="Kudashevs\ShareButtons\Providers\ShareButtonsServiceProvider"
```
> In case of a major change, it is recommended to back up your config file and republish a new one from scratch.

## Assets

By default, this package relies on the `Font Awesome` icons. The buttons interactivity is implemented in two
different ways (via `Vanilla JS` and `jQuery`). However, you can use any custom fonts, icons, or JavaScript.

### Font Awesome and default styles

To enable Font Awesome icons, use the code sample below in your template. For further information on how to use Font Awesome, please read the [introduction](https://fontawesome.com/docs/web/setup/get-started).
```html
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
```

To enable the default styles, you should [publish](#publish) the assets tagged as `css` (the command will create a `resources/css/share-buttons.css` file). After publishing,
you can copy this file to your `public/css` folder and use it directly by applying the code sample below. Or you can integrate the css file into your assets compilation flow.
```html
<link rel="stylesheet" href="{{ asset('css/share-buttons.css') }}">
```

### JavaScript

To enable interaction on social media buttons with JavaScript, you should [publish](#publish) the assets tagged as `vanilla` (the command will create a `resources/js/share-buttons.js` file).
After publishing, you can copy this file to your `public/js` folder and use it directly by applying the code sample below. Or you can integrate this file into your assets compilation flow.
```html
<script src="{{ asset('js/share-buttons.js') }}"></script>
```

### jQuery

To enable interaction on social media buttons with jQuery, you should [publish](#publish) the assets tagged as `jquery` (the command will create a `resources/js/share-buttons.jquery.js` file).
After publishing, you can copy this file to your `public/js` folder and use it directly by applying the code sample below. Or you can integrate this file into your assets compilation flow.
```html
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script src="{{ asset('js/share-buttons.jquery.js') }}"></script>
```

## Usage

This package is highly customizable and easy to use. Let's take a look at a short usage example (a detailed usage example is located in [A detailed usage example](#a-detailed-usage-example) section).
```php
ShareButtons::page('https://site.com', 'Page title', [
        'title' => 'Page title',
        'rel' => 'nofollow noopener noreferrer',
    ])
    ->facebook()
    ->linkedin(['rel' => 'follow'])
    ->render();
```

The code above will result into the following HTML code:
```html
<div id="social-buttons">
    <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fsite.com&quote=Page+title" class="social-button" title="Page title" rel="nofollow noopener noreferrer"><span class="fab fa-facebook-square"></span></a>
    <a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fsite.com&title=Page+title&summary=" class="social-button" title="Page title" rel="follow"><span class="fab fa-linkedin"></span></a>
</div>
```

### Fluent interface

The `ShareButtons` instance provides a fluent interface. The fluent interface is a pattern based on method chaining.
To start a method chaining you just need to use one of the methods listed below (the starting point).
```
page($url, $title, $options)              # Creates a chaining with a given URL and a given page title
createForPage($url, $title, $options)     # Does the same (an alias of the page() method)
currentPage($title, $options)             # Creates a chaining with the current page URL and a given page title
createForCurrentPage($title, $options)    # Does the same (an alias of the currentPage() method)
```

### Add buttons

To create a single social media share button, you just need to add one of the following methods to the method chaining. Each of these
methods accepts an array of options (you can find more information about these options in the [Optional parameters](#optional-parameters) section).

[//]: # (@todo don't forget to update these methods)
```
facebook($options)      # Generates a Facebook share button
twitter($options)       # Generates a Twitter share button
linkedin($options)      # Generates a LinkedIn share button
telegram($options)      # Generates a Telegram share button
whatsapp($options)      # Generates a WhatsApp share button
reddit($options)        # Generates a Reddit share button
hackernews($options)    # Generates a Hacker News share button
vkontakte($options)     # Generates a VKontakte share button
pinterest($options)     # Generates a Pinterest share button
pocket($options)        # Generates a Pocket share button
evernote($options)      # Generates an Evernote share button
skype($options)         # Generates a Skype share button
xing($options)          # Generates a Xing share button
copylink($options)      # Generates a copy to the clipboard share button
mailto($options)        # Generates a send by mail share button
```

These methods are a part of the fluent interface. Therefore, to create multiple social media share buttons you just need to chain them.

### Getting share buttons

You can use a ShareButtons instance as a string or cast it to a string to get ready-to-use HTML code. However, this is not the best way.
If you want to be clear in your intentions, use `render` or `getShareButtons` methods to get the prepared result.
```php
render()                # Returns a generated share buttons HTML code
getShareButtons()       # Does the same (an alias of the render() method)
```

### Getting raw links

Sometimes, you may only want the raw links without any HTML. In such a case, just use the `getRawLinks` method.
```php
getRawLinks()           # Returns an array of generated links
```

## Parameters

There is the possibility to provide different options to style and decorate the resulting HTML code at different levels.

### Global options (main parameters)

Every time a chaining method is called it takes several arguments, including a page URL (it depends on the exact method),
a page title, and an array of options. These are global options that will be used to form the visual representation and 
URLs of share buttons. They will be applied to every element during processing. These options include:
```
'block_prefix' => 'tag'          # Sets a share buttons block prefix (default is <div id="social-buttons">)
'block_suffix' => 'tag'          # Sets a share buttons block suffix (default is </div>)
'element_prefix' => 'tag'        # Sets an element prefix (default is empty)
'element_suffix' => 'tag'        # Sets an element suffix (default is empty)
'id' => 'value'                  # Adds an HTML id attribute to the output links
'class' => 'value'               # Adds an HTML class attribute to the output links
'title' => 'value'               # Adds an HTML title attribute to the output links
'rel' => 'value'                 # Adds an HTML rel attribute to the output links
```

### Local options (optional parameters)

Each of the [add share button methods](#add-buttons) takes several arguments. These are local options that will be applied to
the specific element only. The local options have the **higher priority**. Therefore, they will overwrite the global options
if there is any overlap. At the moment, the package supports the following local options:
```
'id' => 'value'                  # Adds an HTML id attribute to the button link
'class' => 'value'               # Adds an HTML class attribute to the button link
'title' => 'value'               # Adds an HTML title attribute to the button link
'rel' => 'value'                 # Adds an HTML rel attribute to the button link
'summary' => 'value'             # Adds a summary text to the URL (linkedin button only)
```

## A detailed usage example

To summarize all of the information above, we begin with a method that starts a fluent interface and accepts some global options. Then we chain the methods
that create social media share buttons and accept the local options (optional parameters). Then we use one of the methods to return the resulting HTML code.
```php
ShareButtons::page('https://site.com', 'Page title', [
        'block_prefix' => '<ul>',
        'block_suffix' => '</ul>',
        'element_prefix' => '<li>',
        'element_suffix' => '</li>',
        'class' => 'my-class',
        'id' => 'my-id',
        'title' => 'my-title',
        'rel' => 'nofollow noopener noreferrer',
    ])
    ->facebook()
    ->linkedin(['id' => 'linked', 'class' => 'hover', 'rel' => 'follow', 'summary' => 'cool summary'])
    ->render();
```

The code above will result into the following HTML code:
```html
<ul>
    <li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fsite.com&quote=Page+title" class="social-button my-class" id="my-id" title="my-title" rel="nofollow noopener noreferrer"><span class="fab fa-facebook-square"></span></a></li>
    <li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fsite.com&title=Page+title&summary=cool+summary" class="social-button hover" id="linked" title="my-title" rel="follow"><span class="fab fa-linkedin"></span></a></li>
</ul>
```

## Configuration

All of the available configuration settings are located in the `config/share-buttons.php` file.

### Representation section
```
'block_prefix' => 'tag'         # Sets a block prefix (default is <div id="social-buttons">)
'block_suffix' => 'tag'         # Sets a block suffix (default is </div>)
'element_prefix' => 'tag'       # Sets an element prefix (default is empty)
'element_suffix' => 'tag'       # Sets an element suffix (default is empty)
```

### Share buttons section

Each social media share button has its individual configuration settings.
```
'url' => 'value'                # A share button URL template (used to form a button's URL)
'text' => 'value'               # A default text for the title (used when the page title is empty)
'extra' => []                   # Extra options which are required by some specific buttons
```

### Templates section

Each share button has a link representation represented by a corresponding template. A template contains some elements
that will be changed during processing. The format of substituted elements depends on the `templater` setting.
```
:url                            # Will be replaced with a prepared URL
:id                             # Will be replaced with an id attribute
:class                          # Will be replaced with a class attribute
:title                          # Will be replaced with a title attribute
:rel                            # Will be replaced with a rel attribute
```

### Templaters section
```
'templater'                         # A template engine (templater) class
```
 

## Testing
```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
