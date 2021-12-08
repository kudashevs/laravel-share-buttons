<?php

namespace Kudashevs\ShareButtons\Tests;

use Kudashevs\ShareButtons\Formatters\TranslateFormatter;
use Kudashevs\ShareButtons\ShareButtons;

class ShareButtonsTest extends ExtendedTestCase
{
    private $share;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to initialize a container

        $formatter = new TranslateFormatter();
        $this->share = new ShareButtons($formatter);
    }

    /** @test */
    public function it_can_throw_error_on_wrong_provider_name()
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('method ShareButtons::wrong()');

        $this->share->page('https://mysite.com')->wrong();
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
        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com/" class="social-button"><span class="fab fa-facebook-square"></span></a></li></ul></div>';

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

    /** @test */
    public function it_can_return_one_link_on_string_casting()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook();

        $this->assertStringContainsString('facebook', (string)$result);
    }

    /** @test */
    public function it_can_return_one_link_on_get_share_buttons()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->getShareButtons();

        $this->assertStringContainsString('facebook', $result);
    }

    /**
     * @test
     * @dataProvider provide_different_share_providers_for_one_link
     */
    public function it_can_return_one_link_on_different_share_providers($media, $url, $title, $expected)
    {
        $result = $this->share->page($url, $title)
            ->$media()
            ->getRawLinks();

        $this->assertEquals([$media => $expected], $result);
    }

    public function provide_different_share_providers_for_one_link()
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

    /** @test */
    public function it_can_generate_multiple_share_links_at_once()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->pinterest()
            ->reddit()
            ->telegram();

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button"><span class="fab fa-twitter"></span></a></li><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+share+title&summary=" class="social-button"><span class="fab fa-linkedin"></span></a></li><li><a href="https://wa.me/?text=https://mysite.com" class="social-button" target="_blank"><span class="fab fa-whatsapp"></span></a></li><li><a href="https://pinterest.com/pin/create/button/?url=https://mysite.com" class="social-button"><span class="fab fa-pinterest"></span></a></li><li><a href="https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com" class="social-button" target="_blank"><span class="fab fa-reddit"></span></a></li><li><a href="https://telegram.me/share/url?url=https://mysite.com&text=My+share+title" class="social-button" target="_blank"><span class="fab fa-telegram"></span></a></li></ul></div>';
        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_multiple_share_links_at_once_and_multiple_times_after_each_other()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->twitter()
            ->linkedin();

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button"><span class="fab fa-twitter"></span></a></li><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+share+title&summary=" class="social-button"><span class="fab fa-linkedin"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);

        $result = $this->share->page('https://mysite.com', 'My share title')
            ->reddit()
            ->telegram();

        $expected = '<div id="social-links"><ul><li><a href="https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com" class="social-button" target="_blank"><span class="fab fa-reddit"></span></a></li><li><a href="https://telegram.me/share/url?url=https://mysite.com&text=My+share+title" class="social-button" target="_blank"><span class="fab fa-telegram"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_multiple_share_links_at_once_with_extra_options()
    {
        $result = $this->share->page(
            'https://mysite.com',
            'My share title',
            [
                'block_prefix' => '<ul>',
                'block_suffix' => '</ul>',
                'class' => 'my-class',
                'id' => 'my-id',
                'title' => 'My Title for SEO',
                'rel' => 'nofollow',
            ])
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->pinterest()
            ->reddit()
            ->telegram();

        $expected = '<ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-twitter"></span></a></li><li><a href="https://wa.me/?text=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow" target="_blank"><span class="fab fa-whatsapp"></span></a></li><li><a href="https://pinterest.com/pin/create/button/?url=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-pinterest"></span></a></li><li><a href="https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow" target="_blank"><span class="fab fa-reddit"></span></a></li><li><a href="https://telegram.me/share/url?url=https://mysite.com&text=My+share+title" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow" target="_blank"><span class="fab fa-telegram"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_return_one_link_and_use_string_argument_as_title()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->linkedin('This is a title');

        $expected = '<div id="social-links"><ul><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=This+is+a+title&summary=" class="social-button" title="This is a title"><span class="fab fa-linkedin"></span></a></li></ul></div>';
        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_return_one_link_and_override_title_with_provider_arguments()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->linkedin(['title' => 'This is another title']);

        $expected = '<div id="social-links"><ul><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=This+is+another+title&summary=" class="social-button" title="This is another title"><span class="fab fa-linkedin"></span></a></li></ul></div>';
        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_multiple_share_links_and_add_provider_arguments()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook(['rel' => 'nofollow'])
            ->linkedin(['summary' => 'Test summary', 'class' => 'active'])
            ->twitter(['rel' => 'follow']);

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+share+title&summary=Test+summary" class="social-button active"><span class="fab fa-linkedin"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button" rel="follow"><span class="fab fa-twitter"></span></a></li></ul></div>';
        $this->assertEquals($expected, (string)$result);
    }
}
