<?php

namespace ShareButtons\Share\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @todo constantly update this signature mapper.
 *
 * @method page($url, string $title = '', array $options = [], ?string $prefix = null, ?string $suffix = null)
 * @method currentPage($url, string $title = '', array $options = [], ?string $prefix = null, ?string $suffix = null)
 * @method facebook()
 * @method twitter()
 * @method reddit()
 * @method telegram()
 * @method whatsapp()
 * @method linkedin(string $summary = '')
 * @method pinterest()
 * @method array getRawLinks()
 */
class ShareButtonsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return static::$app['share'];
    }
}
