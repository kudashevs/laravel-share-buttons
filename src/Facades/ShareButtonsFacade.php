<?php

namespace Kudashevs\ShareButtons\Facades;

use Illuminate\Support\Facades\Facade;
use Kudashevs\ShareButtons\ShareButtons;

/**
 * @todo constantly update these method signatures.
 *
 * @method ShareButtons page($url, string $title = '', array $options = [])
 * @method ShareButtons currentPage($url, string $title = '', array $options = [])
 * @method ShareButtons facebook($option = [])
 * @method ShareButtons linkedin($option = [])
 * @method ShareButtons pinterest($option = [])
 * @method ShareButtons reddit($option = [])
 * @method ShareButtons telegram($option = [])
 * @method ShareButtons twitter($option = [])
 * @method ShareButtons whatsapp($option = [])
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
