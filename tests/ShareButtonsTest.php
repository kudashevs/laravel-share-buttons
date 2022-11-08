<?php

namespace Kudashevs\ShareButtons\Tests;

use Kudashevs\ShareButtons\Facades\ShareButtonsFacade;
use Kudashevs\ShareButtons\Formatters\TemplateFormatter;
use Kudashevs\ShareButtons\ShareButtons;

class ShareButtonsTest extends ExtendedTestCase
{
    private $share;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $formatter = new TemplateFormatter();
        $this->share = new ShareButtons($formatter);
    }

    /** @test */
    public function it_can_throw_default_exception_when_wrong_provider_name()
    {
        config()->set('share-buttons.reactOnErrors', true);

        $this->expectException(\Error::class);
        $this->expectExceptionMessage('method ShareButtons::wrong()');

        ShareButtonsFacade::page('https://mysite.com')->wrong();
    }

    /** @test */
    public function it_can_throw_provided_exception_when_wrong_provider_name()
    {
        config()->set('share-buttons.reactOnErrors', true);
        config()->set('share-buttons.throwException', \BadMethodCallException::class);

        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('method ShareButtons::wrong()');

        ShareButtonsFacade::page('https://mysite.com')->wrong();
    }

    /** @test */
    public function it_can_throw_default_exception_when_wrong_provided_exception_class()
    {
        config()->set('share-buttons.reactOnErrors', true);
        config()->set('share-buttons.throwException', Wrong::class);

        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('method ShareButtons::wrong()');

        ShareButtonsFacade::page('https://mysite.com')->wrong();
    }

    /** @test */
    public function it_can_skip_throwing_exception_when_wrong_provider_name()
    {
        config()->set('share-buttons.throwException', false);

        $result = $this->share->page('https://mysite.com')->wrong()->getRawLinks();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /** @test */
    public function it_creates_self_instance_with_page_method()
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->page('https://mysite.com'));
    }

    /** @test */
    public function it_creates_self_instance_with_current_page_method()
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->currentPage());
    }

    /** @test */
    public function it_create_self_instance_with_create_for_page_method()
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->createForPage('https://mysite.com'));
    }

    /** @test */
    public function it_create_self_instance_with_create_for_current_page_method()
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->createForCurrentPage());
    }

    /** @test */
    public function it_can_generate_one_link_without_a_title()
    {
        $result = $this->share->page('https://mysite.com')->facebook();

        $this->assertStringContainsString('facebook', (string)$result);
    }

    /** @test */
    public function it_can_generate_one_link_without_a_title_for_provider_with_predefined_title()
    {
        $expected = config('share-buttons.providers.twitter.text');

        $result = $this->share->page('https://mysite.com')->twitter();

        $this->assertStringContainsString(urlencode($expected), (string)$result);
    }

    /** @test */
    public function it_can_generate_one_link_with_a_provided_title_for_provider_with_predefined_title()
    {
        $expected = 'Page title';

        $result = $this->share->page('https://mysite.com', $expected)->twitter();

        $this->assertStringContainsString(urlencode($expected), (string)$result);
    }
    /** @test */
    public function it_can_generate_one_link_with_page_method()
    {
        $result = $this->share->page('https://mysite.com')->facebook();

        $this->assertStringContainsString('facebook', (string)$result);
    }

    /** @test */
    public function it_can_generate_one_link_with_current_page_method()
    {
        $result = $this->share->currentPage()->facebook();

        $this->assertStringContainsString('facebook', (string)$result);
    }

    /** @test */
    public function it_can_generate_one_link_with_create_for_page_method()
    {
        $result = $this->share->createForPage('https://mysite.com')->twitter();

        $this->assertStringContainsString('twitter', (string)$result);
    }

    /** @test */
    public function it_can_generate_one_link_with_create_for_current_page_method_using_request()
    {
        $result = $this->share->createForCurrentPage()->twitter();

        $this->assertStringContainsString('twitter', (string)$result);
    }

    /** @test */
    public function it_can_return_empty_array_without_links_with_get_raw_links_method()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->getRawLinks();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /** @test */
    public function it_can_return_one_link_with_get_raw_links_method()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->getRawLinks();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    /** @test */
    public function it_can_return_multiple_links_at_once_with_get_raw_links_method()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->twitter()
            ->reddit()
            ->telegram()
            ->getRawLinks();

        $expected = [
            'twitter' => 'https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com',
            'reddit' => 'https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com',
            'telegram' => 'https://telegram.me/share/url?url=https://mysite.com&text=My+share+title',
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_return_one_link_with_string_casting()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook();

        $this->assertStringContainsString('facebook', (string)$result);
    }

    /** @test */
    public function it_can_return_one_link_with_get_share_buttons_method()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->getShareButtons();

        $this->assertStringContainsString('facebook', $result);
    }

    /** @test */
    public function it_can_return_multiple_links_at_once_with_get_share_buttons_method()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->twitter()
            ->reddit()
            ->telegram()
            ->getShareButtons();

        $this->assertStringContainsString('twitter', $result);
        $this->assertStringContainsString('reddit', $result);
        $this->assertStringContainsString('telegram', $result);
    }

    /** @test */
    public function it_can_generate_multiple_share_links_at_once()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->linkedin()
            ->whatsapp();

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=My+share+title" class="social-button"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+share+title&summary=" class="social-button"><span class="fab fa-linkedin"></span></a></li><li><a href="https://wa.me/?text=https://mysite.com" class="social-button" target="_blank"><span class="fab fa-whatsapp"></span></a></li></ul></div>';
        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_multiple_share_links_at_once_and_multiple_times_after_each_other()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->twitter()
            ->linkedin();

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=My+share+title" class="social-button"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button"><span class="fab fa-twitter"></span></a></li><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+share+title&summary=" class="social-button"><span class="fab fa-linkedin"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);

        $result = $this->share->page('https://mysite.com', 'My share title')
            ->reddit()
            ->telegram();

        $expected = '<div id="social-links"><ul><li><a href="https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com" class="social-button"><span class="fab fa-reddit"></span></a></li><li><a href="https://telegram.me/share/url?url=https://mysite.com&text=My+share+title" class="social-button" target="_blank"><span class="fab fa-telegram"></span></a></li></ul></div>';

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
                'title' => 'My Title for SEO',
                'class' => 'page-class',
                'id' => 'page-id',
                'rel' => 'nofollow',
            ])
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->reddit()
            ->telegram();

        $expected = '<ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=My+share+title" class="social-button page-class" id="page-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button page-class" id="page-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-twitter"></span></a></li><li><a href="https://wa.me/?text=https://mysite.com" class="social-button page-class" id="page-id" title="My Title for SEO" rel="nofollow" target="_blank"><span class="fab fa-whatsapp"></span></a></li><li><a href="https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com" class="social-button page-class" id="page-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-reddit"></span></a></li><li><a href="https://telegram.me/share/url?url=https://mysite.com&text=My+share+title" class="social-button page-class" id="page-id" title="My Title for SEO" rel="nofollow" target="_blank"><span class="fab fa-telegram"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_multiple_share_links_and_add_provider_arguments()
    {
        $result = $this->share->page('https://mysite.com', 'Page share title')
            ->facebook(['rel' => 'nofollow'])
            ->linkedin(['summary' => 'Test summary', 'class' => 'active'])
            ->twitter(['rel' => 'follow']);

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Page+share+title" class="social-button" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=Page+share+title&summary=Test+summary" class="social-button active"><span class="fab fa-linkedin"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=Page+share+title&url=https://mysite.com" class="social-button" rel="follow"><span class="fab fa-twitter"></span></a></li></ul></div>';
        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_multiple_share_links_at_once_with_extra_options_and_provider_arguments()
    {
        $result = $this->share->page(
            'https://mysite.com',
            'My share title',
            [
                'block_prefix' => '<ul>',
                'block_suffix' => '</ul>',
                'title' => 'My page title for SEO',
                'class' => 'page-class',
                'id' => 'page-id',
                'rel' => 'nofollow',
            ])
            ->facebook()
            ->twitter(['title' => 'Provider title'])
            ->whatsapp()
            ->reddit(['id' => 'provider-id', 'class' => 'provider-class', 'rel' => 'provider'])
            ->telegram(['wrong' => null]);

        $expected = '<ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=My+share+title" class="social-button page-class" id="page-id" title="My page title for SEO" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button page-class" id="page-id" title="Provider title" rel="nofollow"><span class="fab fa-twitter"></span></a></li><li><a href="https://wa.me/?text=https://mysite.com" class="social-button page-class" id="page-id" title="My page title for SEO" rel="nofollow" target="_blank"><span class="fab fa-whatsapp"></span></a></li><li><a href="https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com" class="social-button provider-class" id="provider-id" title="My page title for SEO" rel="provider"><span class="fab fa-reddit"></span></a></li><li><a href="https://telegram.me/share/url?url=https://mysite.com&text=My+share+title" class="social-button page-class" id="page-id" title="My page title for SEO" rel="nofollow" target="_blank"><span class="fab fa-telegram"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }
}
