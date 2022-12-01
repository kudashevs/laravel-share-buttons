<?php

namespace Kudashevs\ShareButtons\Facades;

use Illuminate\Support\Facades\Facade;
use Kudashevs\ShareButtons\ShareButtons;

/**
 * @todo don't forget to update these method signatures
 *
 * @method ShareButtons page($url, string $title = '', array $options = [])
 * @method ShareButtons currentPage($url, string $title = '', array $options = [])
 * @method ShareButtons copylink(array $options = [])
 * @method ShareButtons evernote(array $options = [])
 * @method ShareButtons facebook(array $options = [])
 * @method ShareButtons hackernews(array $options = [])
 * @method ShareButtons linkedin(array $options = [])
 * @method ShareButtons mailto(array $options = [])
 * @method ShareButtons pinterest(array $options = [])
 * @method ShareButtons pocket(array $options = [])
 * @method ShareButtons reddit(array $options = [])
 * @method ShareButtons skype(array $options = [])
 * @method ShareButtons telegram(array $options = [])
 * @method ShareButtons twitter(array $options = [])
 * @method ShareButtons vkontakte(array $options = [])
 * @method ShareButtons whatsapp(array $options = [])
 * @method ShareButtons xing(array $options = [])
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
        return 'sharebuttons';
    }
}
