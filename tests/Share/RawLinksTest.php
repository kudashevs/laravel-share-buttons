<?php

namespace ShareButtons\Share\Test\Share;

use ShareButtons\Share\Facades\ShareFacade;
use ShareButtons\Share\Test\ExtendedTestCase;

class RawLinksTest extends ExtendedTestCase
{

    /** @test */
    public function it_can_return_empty_array_with_no_links()
    {
        $result = ShareFacade::page('https://mysite.com', 'My share title')
            ->getRawLinks();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /** @test */
    public function it_can_return_one_link()
    {
        $result = ShareFacade::page('https://mysite.com', 'My share title')
            ->facebook()
            ->getRawLinks();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function provide_media_for_one_link()
    {
        return [
            'facebook' => [
                'facebook',
                'https://mysite.com',
                'My facebook title',
                'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com',
            ],
            'twitter' => [
                'twitter',
                'https://mysite.com',
                'My twitter title',
                'https://twitter.com/intent/tweet?text=My+twitter+title&url=https://mysite.com',
            ],
            'linkedin' => [
                'linkedin',
                'https://mysite.com',
                'My linkedin title',
                'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+linkedin+title&summary=',
            ],
            'whatsapp' => [
                'whatsapp',
                'https://mysite.com',
                'My whatsapp title',
                'https://wa.me/?text=https://mysite.com'],
            'pinterest' => [
                'pinterest',
                'https://mysite.com',
                'My pinterest title',
                'https://pinterest.com/pin/create/button/?url=https://mysite.com',
            ],
            'reddit' => [
                'reddit',
                'https://mysite.com',
                'My reddit title',
                'https://www.reddit.com/submit?title=My+reddit+title&url=https://mysite.com',
            ],
            'telegram' => [
                'telegram',
                'https://mysite.com',
                'My telegram title',
                'https://telegram.me/share/url?url=https://mysite.com&text=My+telegram+title',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provide_media_for_one_link
     */
    public function it_returns_one_link($media, $link, $title, $expected)
    {
        $result = ShareFacade::page($link, $title)
            ->$media()
            ->getRawLinks();

        $this->assertEquals([$media => $expected], $result);
    }

    /** @test */
    public function it_can_return_multiple_built_links_at_once()
    {
        $result = ShareFacade::page('https://mysite.com', 'My share title')
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->pinterest()
            ->reddit()
            ->telegram()
            ->getRawLinks();

        $expected = [
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com',
            'twitter' => 'https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com',
            'linkedin' => 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+share+title&summary=',
            'whatsapp' => 'https://wa.me/?text=https://mysite.com',
            'pinterest' => 'https://pinterest.com/pin/create/button/?url=https://mysite.com',
            'reddit' => 'https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com',
            'telegram' => 'https://telegram.me/share/url?url=https://mysite.com&text=My+share+title',
        ];

        $this->assertEquals($expected, $result);
    }
}
