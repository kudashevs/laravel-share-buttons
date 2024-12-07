# Laravel Share Buttons ![test workflow](https://github.com/kudashevs/laravel-share-buttons/actions/workflows/run-tests.yml/badge.svg)

This Laravel package provides the possibility to generate share links (social media share buttons) for your site in
a flexible and convenient way within seconds. The package was originated from the Laravel Share.

[//]: # (@todo don't forget to update these services)
### Available services

* Facebook
* X (formerly Twitter)
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
],
```
By default, the `ShareButtons` class instance is bound to the `sharebuttons` alias.

<a id="publish"></a>**Note**: Don't forget to publish the configuration file (required) and assets.
```bash
php artisan vendor:publish --provider="Kudashevs\ShareButtons\Providers\ShareButtonsServiceProvider"
```
> In case of a major change, it is recommended to back up your config file and republish a new one from scratch.

If you want to publish certain assets only, use the `--tag` option with one of the following assets tags: `config`, `css`,
`js` (includes all possible js files), `vanilla`, `jquery`.


## Assets

By default, this package relies on the `Font Awesome` icons. The buttons' interactivity is implemented in two
different ways (via `Vanilla JS` and `jQuery`). However, you can use any custom fonts, icons, or JavaScript.

### Font Awesome and default styles

To enable Font Awesome icons, you can load it from a CDN. For more information on how to use Font Awesome, please read the [introduction](https://fontawesome.com/docs/web/setup/get-started).
```html
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
```

To enable the default styles, [publish](#publish) the `css` asset (the command will create a `resources/css/share-buttons.css` file).
After publishing, you can copy the file to the `public/css` folder and use it directly. Or you can integrate the css file into
your assets building process.
```html
<link rel="stylesheet" href="{{ asset('css/share-buttons.css') }}">
```

### JavaScript

To enable interaction on social media buttons with JavaScript, [publish](#publish) the `vanilla` asset (the command will create a `resources/js/share-buttons.js` file).
After publishing, you can copy the file to the `public/js` folder and use it directly. Or you can integrate this file into
your assets building process.
```html
<script src="{{ asset('js/share-buttons.js') }}"></script>
```

### jQuery

To enable interaction on social media buttons with jQuery, [publish](#publish) the `jquery` asset (the command will create a `resources/js/share-buttons.jquery.js` file).
After publishing, you can copy the file to the `public/js` folder and use it directly. Or you can integrate this file into
your assets building process.
```html
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script src="{{ asset('js/share-buttons.jquery.js') }}"></script>
```


## Usage

Let's take a look at a short usage example (you can find a detailed usage example in the [corresponding section](#a-detailed-usage-example)).
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

To generate a single social media button, you just need to add one of the following methods to the [method chaining](#fluent-interface).
Each method accepts an array of options (more information about these options in the [local options](#local-options) section).

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
If you want to be clear in your intentions, use one of the methods that return generated HTML code. These methods are:
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

There is the possibility of providing different options to style and decorate the resulting HTML code at different levels.

### Global options

Every time a chaining method is called, it accepts several arguments, including a page URL (depending on the method), a page title,
and an array of options. These options are global because they change the representation of all share buttons. These options are:
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

### Local options

Any of the [share button methods](#add-buttons), that generates a button, accepts several arguments. These options are local
because they will be applied to a specific element only. The local options have a **higher priority**. Therefore, they
will overwrite the global options if there is any overlap. At the moment, the package supports the following local options:
```
'text' => 'value'                # Adds a link text to a generated URL (overrides global page title)
'id' => 'value'                  # Adds an HTML id attribute to the button link
'class' => 'value'               # Adds an HTML class attribute to the button link
'title' => 'value'               # Adds an HTML title attribute to the button link
'rel' => 'value'                 # Adds an HTML rel attribute to the button link
'summary' => 'value'             # Adds a summary text to the URL (linkedin button only)
```

## Configuration

The configuration settings are located in the `config/share-buttons.php` file.

### Representation section

This section contains settings related to the "container" in which the social media buttons will be displayed.
```
'block_prefix' => 'tag'         # Sets a block prefix (default is <div id="social-buttons">)
'block_suffix' => 'tag'         # Sets a block suffix (default is </div>)
'element_prefix' => 'tag'       # Sets an element prefix (default is empty)
'element_suffix' => 'tag'       # Sets an element suffix (default is empty)
```

### Share buttons section

Each social media share button has its own individual configuration settings.
```
'url' => 'value'                # A share button URL template (is used to generate a button's URL)
'text' => 'value'               # A default text to be added to the url (is used when the page title is empty)
'extra' => [                    # Extra options that are required by some specific buttons
    'summary' => 'value'        # A default summary to be added to the url (linkedin only) 
    'raw' => 'value'            # A boolean defines whether to skip the URL-encoding of the url
    'hash' => 'value'           # A boolean defines whether to use a hash instead of the url
]
```
**Note**: a text value might contain a `url` element, which will be replaced by the page url while processing.

### Templates section

Each share button has a corresponding link template. A template contains several elements that will be substituted with
data from different arguments and options. The format of these elements depends on the `templater` setting. By default,
these elements are:
```
:url                            # Will be replaced with a prepared URL
:id                             # Will be replaced with an id attribute
:class                          # Will be replaced with a class attribute
:title                          # Will be replaced with a title attribute
:rel                            # Will be replaced with a rel attribute
```

### Templaters section

For processing different templates and substitute elements in them, the package uses templaters (template engines).
By default, these options are optional (if no value provided, the default templater will be used). 
```
'templater'                     # A template engine for processing link templates
'url_templater'                 # A template engine for processing share buttons URLs
```


## A detailed usage example

To summarize all of the information from above, let's take a look at a real-life example. We begin with one of the methods
that start the fluent interface, and we provide some global options. Then, we add some specific methods that generate social
media share buttons. At this step, we can provide any local options, as it is done in the `linkedin()` method. Finally,
we finish the fluent interface chain with one of the methods that return the resulting HTML code.
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


## Testing

If you want to make sure that everything works as expected, you can run unit tests provided with the package.
```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see the [License file](LICENSE.md) for more information.