<?php

namespace Kudashevs\ShareButtons\Tests\Acceptance;

use Kudashevs\ShareButtons\ShareButtons;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class ShareButtonsTest extends ExtendedTestCase
{
    private $share;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->share = new ShareButtons();
    }

    /**
     * @test
     * @dataProvider provide_different_share_providers_for_one_link
     * @param string $media
     * @param string $url
     * @param string $title
     * @param string $expected
     */
    public function it_can_return_one_link_with_different_share_providers(string $media, string $url, string $title, string $expected)
    {
        $result = $this->share->page($url, $title)
            ->$media()
            ->getRawLinks();

        $this->assertEquals([$media => $expected], $result);
    }

    /**
     * @todo don't forget to update these test cases
     */
    public function provide_different_share_providers_for_one_link()
    {
        return [
            'copylink' => [
                'copylink',
                'https://mysite.com',
                'My facebook title',
                'https://mysite.com',
            ],
            'evernote' => [
                'evernote',
                'https://mysite.com',
                'My evernote title',
                'https://www.evernote.com/clip.action?url=https://mysite.com&t=My+evernote+title',
            ],
            'facebook' => [
                'facebook',
                'https://mysite.com',
                'My facebook title',
                'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=My+facebook+title',
            ],
            'hackernews' => [
                'hackernews',
                'https://mysite.com',
                'My hacker news title',
                'https://news.ycombinator.com/submitlink?t=My+hacker+news+title&u=https://mysite.com',
            ],
            'linkedin' => [
                'linkedin',
                'https://mysite.com',
                'My linkedin title',
                'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+linkedin+title&summary=',
            ],
            'mailto' => [
                'mailto',
                'https://mysite.com',
                'My share by mail title',
                'mailto:?subject=My+share+by+mail+title&body=https://mysite.com',
            ],
            'pinterest' => [
                'pinterest',
                'https://mysite.com',
                'My pinterest title',
                'https://pinterest.com/pin/create/button/?url=https://mysite.com',
            ],
            'pocket' => [
                'pocket',
                'https://mysite.com',
                'My pocket title',
                'https://getpocket.com/edit?url=https://mysite.com&title=My+pocket+title',
            ],
            'reddit' => [
                'reddit',
                'https://mysite.com',
                'My reddit title',
                'https://www.reddit.com/submit?title=My+reddit+title&url=https://mysite.com',
            ],
            'skype' => [
                'skype',
                'https://mysite.com',
                'My skype title',
                'https://web.skype.com/share?url=https://mysite.com&text=My+skype+title&source=button',
            ],
            'telegram' => [
                'telegram',
                'https://mysite.com',
                'My telegram title',
                'https://telegram.me/share/url?url=https://mysite.com&text=My+telegram+title',
            ],
            'twitter' => [
                'twitter',
                'https://mysite.com',
                'My twitter title',
                'https://twitter.com/intent/tweet?text=My+twitter+title&url=https://mysite.com',
            ],
            'vkontakte' => [
                'vkontakte',
                'https://mysite.com',
                'My twitter title',
                'https://vk.com/share.php?url=https://mysite.com&title=My+twitter+title',
            ],
            'whatsapp' => [
                'whatsapp',
                'https://mysite.com',
                'My whatsapp title',
                'https://wa.me/?text=https://mysite.com',
            ],
            'xing' => [
                'xing',
                'https://mysite.com',
                'My xing title',
                'https://www.xing.com/spi/shares/new?url=https://mysite.com',
            ],
        ];
    }
}
