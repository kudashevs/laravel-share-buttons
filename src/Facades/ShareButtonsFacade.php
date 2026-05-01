<?php

namespace Kudashevs\ShareButtons\Facades;

use Illuminate\Support\Facades\Facade;
use Kudashevs\ShareButtons\ShareButtons;

/**
 * @todo don't forget to update these method signatures
 *
 * @method ShareButtons page($url, string $title = '', array<string, string> $options = [])
 * @method ShareButtons currentPage($url, string $title = '', array<string, string> $options = [])
 * @method ShareButtons bluesky(array<string, string> $options = [])
 * @method ShareButtons copylink(array<string, string> $options = [])
 * @method ShareButtons evernote(array<string, string> $options = [])
 * @method ShareButtons facebook(array<string, string> $options = [])
 * @method ShareButtons hackernews(array<string, string> $options = [])
 * @method ShareButtons linkedin(array<string, string> $options = [])
 * @method ShareButtons mailto(array<string, string> $options = [])
 * @method ShareButtons mastodon(array<string, string> $options = [])
 * @method ShareButtons pinterest(array<string, string> $options = [])
 * @method ShareButtons pocket(array<string, string> $options = [])
 * @method ShareButtons reddit(array<string, string> $options = [])
 * @method ShareButtons skype(array<string, string> $options = [])
 * @method ShareButtons telegram(array<string, string> $options = [])
 * @method ShareButtons tumblr(array<string, string> $options = [])
 * @method ShareButtons twitter(array<string, string> $options = [])
 * @method ShareButtons vkontakte(array<string, string> $options = [])
 * @method ShareButtons whatsapp(array<string, string> $options = [])
 * @method ShareButtons xing(array<string, string> $options = [])
 * @method array<string, string> getRawLinks()
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
