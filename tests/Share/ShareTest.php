<?php

namespace Kudashevs\ShareButtons\Test\Share;

use Kudashevs\ShareButtons\ShareButtons;
use Kudashevs\ShareButtons\Test\ExtendedTestCase;

class ShareTest extends ExtendedTestCase
{
    private $share;

    protected function setUp(): void
    {
        $this->share = new ShareButtons();

        parent::setUp();
    }

    /** @test */
    public function it_creates_self_instance_on_page()
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->page('https://mysite.com'));
    }

    /** @test */
    public function it_create_self_instance_on_current_page()
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->currentPage());
    }

    /** @test */
    public function it_can_use_the_url_of_the_current_request()
    {
        $result = $this->share->currentPage()->facebook();
        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com/" class="social-button " id="" title="" rel=""><span class="fab fa-facebook-square"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_return_empty_array_with_no_links_on_get_raw_links()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->getRawLinks();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /** @test */
    public function it_can_return_one_link_on_get_raw_links()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->getRawLinks();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    /** @test */
    public function it_can_return_multiple_links_at_once_on_get_raw_links()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
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

    /**
     * @test
     * @dataProvider provide_media_for_one_link
     */
    public function it_returns_one_link_on_get_raw_links($media, $link, $title, $expected)
    {
        $result = $this->share->page($link, $title)
            ->$media()
            ->getRawLinks();

        $this->assertEquals([$media => $expected], $result);
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
                'https://wa.me/?text=https://mysite.com',
            ],
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
}
