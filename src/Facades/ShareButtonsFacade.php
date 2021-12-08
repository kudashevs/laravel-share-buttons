<?php

namespace Kudashevs\ShareButtons\Facades;

use Illuminate\Support\Facades\Facade;
use Kudashevs\ShareButtons\ShareButtons;

/**
 * @todo constantly update these method signatures.
 *
 * @method ShareButtons page($url, string $title = '', array $options = [])
 * @method ShareButtons currentPage($url, string $title = '', array $options = [])
 * @method ShareButtons facebook(array $option = [])
 * @method ShareButtons linkedin(array $option = [])
 * @method ShareButtons pinterest(array $option = [])
 * @method ShareButtons reddit(array $option = [])
 * @method ShareButtons telegram(array $option = [])
 * @method ShareButtons twitter(array $option = [])
 * @method ShareButtons whatsapp(array $option = [])
 * @method array getRawLinks()
 * @method string getShareButtons()
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
