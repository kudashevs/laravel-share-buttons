<?php

namespace Kudashevs\ShareButtons\Tests\Unit;

use Kudashevs\ShareButtons\ShareButtons;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class ShareButtonsTest extends ExtendedTestCase
{
    private ShareButtons $share;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->share = new ShareButtons();
    }

    /** @test */
    public function it_can_throw_exception_when_a_wrong_share_button_name()
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('ShareButtons::wrong()');

        $instance = new ShareButtons();
        $instance->page('https://mysite.com')->wrong()->getRawLinks();
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
    public function it_creates_self_instance_with_create_for_page_method()
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->createForPage('https://mysite.com'));
    }

    /** @test */
    public function it_creates_self_instance_with_create_for_current_page_method()
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->createForCurrentPage());
    }

    /** @test */
    public function it_can_return_one_link_with_a_predefined_title()
    {
        $expected = config('share-buttons.buttons.twitter.text');

        $result = $this->share->page('https://mysite.com')->twitter();

        $this->assertStringContainsString(urlencode($expected), (string)$result);
    }

    /** @test */
    public function it_can_return_one_link_with_a_provided_title()
    {
        $expected = 'Page title';

        $result = $this->share->page('https://mysite.com', $expected)->twitter();

        $this->assertStringContainsString(urlencode($expected), (string)$result);
    }

    /** @test */
    public function it_can_return_one_link_through_page_method()
    {
        $result = $this->share->page('https://mysite.com')->facebook();

        $this->assertStringContainsString('facebook', (string)$result);
    }

    /** @test */
    public function it_can_return_one_link_through_current_page_method()
    {
        $result = $this->share->currentPage()->facebook();

        $this->assertStringContainsString('facebook', (string)$result);
    }

    /** @test */
    public function it_can_return_one_link_through_create_for_page_method()
    {
        $result = $this->share->createForPage('https://mysite.com')->twitter();

        $this->assertStringContainsString('twitter', (string)$result);
    }

    /** @test */
    public function it_can_return_one_link_through_create_for_current_page_method()
    {
        $result = $this->share->createForCurrentPage()->twitter();

        $this->assertStringContainsString('twitter', (string)$result);
    }

    /** @test */
    public function it_returns_empty_array_through_get_raw_links_method_when_no_calls_provided()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->getRawLinks();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /** @test */
    public function it_can_return_one_link_through_get_raw_links_method()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->getRawLinks();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    /** @test */
    public function it_can_return_multiple_links_at_once_through_get_raw_links_method()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->twitter()
            ->reddit()
            ->telegram()
            ->getRawLinks();

        $this->assertCount(3, $result);
        $this->assertStringContainsString('twitter', $result['twitter']);
        $this->assertStringContainsString('reddit', $result['reddit']);
        $this->assertStringContainsString('telegram', $result['telegram']);
    }

    /** @test */
    public function it_returns_empty_string_through_string_casting_when_no_calls_provided()
    {
        $result = $this->share->page('https://mysite.com', 'My share title');

        $this->assertStringContainsString('', (string)$result);
    }

    /** @test */
    public function it_can_return_one_link_through_string_casting()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook();

        $this->assertStringContainsString('facebook', (string)$result);
    }

    /** @test */
    public function it_can_return_multiple_links_through_string_casting()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->twitter()
            ->reddit()
            ->telegram();

        $this->assertStringContainsString('twitter', (string)$result);
        $this->assertStringContainsString('reddit', (string)$result);
        $this->assertStringContainsString('telegram', (string)$result);
    }

    /** @test */
    public function it_returns_empty_string_through_render_method_when_no_calls_provided()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->render();

        $this->assertStringContainsString('', $result);
    }

    /** @test */
    public function it_can_return_one_link_through_render_method()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->render();

        $this->assertStringContainsString('facebook', $result);
    }

    /** @test */
    public function it_can_return_multiple_links_through_render_method()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->twitter()
            ->reddit()
            ->telegram()
            ->render();

        $this->assertStringContainsString('twitter', $result);
        $this->assertStringContainsString('reddit', $result);
        $this->assertStringContainsString('telegram', $result);
    }

    /** @test */
    public function it_returns_empty_string_through_get_share_buttons_method_when_no_calls_provided()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->getShareButtons();;

        $this->assertStringContainsString('', $result);
    }

    /** @test */
    public function it_can_return_one_link_through_get_share_buttons_method()
    {
        $result = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->getShareButtons();

        $this->assertStringContainsString('facebook', $result);
    }

    /** @test */
    public function it_can_return_multiple_links_through_get_share_buttons_method()
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
    public function it_can_return_multiple_links_and_then_multiple_links_another_time()
    {
        $result = $this->share->page('https://mysite.com', 'My first title')
            ->facebook()
            ->twitter()
            ->linkedin();

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=My+first+title" class="social-button"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+first+title&url=https%3A%2F%2Fmysite.com" class="social-button"><span class="fab fa-twitter"></span></a></li><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=My+first+title&summary=" class="social-button"><span class="fab fa-linkedin"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);

        $result = $this->share->page('https://mysite.com', 'My second title')
            ->reddit()
            ->telegram();

        $expected = '<div id="social-links"><ul><li><a href="https://www.reddit.com/submit?title=My+second+title&url=https%3A%2F%2Fmysite.com" class="social-button"><span class="fab fa-reddit"></span></a></li><li><a href="https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=My+second+title" class="social-button" target="_blank"><span class="fab fa-telegram"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_return_multiple_links_with_extra_options()
    {
        $result = $this->share->page(
            'https://mysite.com',
            'Page share title',
            [
                'block_prefix' => '<ul>',
                'block_suffix' => '</ul>',
                'title' => 'link title',
                'class' => 'page-class',
                'id' => 'page-id',
                'rel' => 'nofollow',
            ])
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->reddit()
            ->telegram();

        $expected = '<ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Page+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=Page+share+title&url=https%3A%2F%2Fmysite.com" class="social-button page-class" id="page-id" title="link title" rel="nofollow"><span class="fab fa-twitter"></span></a></li><li><a href="https://wa.me/?text=https%3A%2F%2Fmysite.com%20Page+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow" target="_blank"><span class="fab fa-whatsapp"></span></a></li><li><a href="https://www.reddit.com/submit?title=Page+share+title&url=https%3A%2F%2Fmysite.com" class="social-button page-class" id="page-id" title="link title" rel="nofollow"><span class="fab fa-reddit"></span></a></li><li><a href="https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=Page+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow" target="_blank"><span class="fab fa-telegram"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_return_multiple_links_with_provided_arguments()
    {
        $result = $this->share->page('https://mysite.com', 'Page share title')
            ->facebook(['rel' => 'nofollow'])
            ->linkedin(['summary' => 'Test summary', 'class' => 'active'])
            ->twitter(['rel' => 'follow']);

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Page+share+title" class="social-button" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=Page+share+title&summary=Test+summary" class="social-button active"><span class="fab fa-linkedin"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=Page+share+title&url=https%3A%2F%2Fmysite.com" class="social-button" rel="follow"><span class="fab fa-twitter"></span></a></li></ul></div>';
        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_return_multiple_links_with_extra_options_and_provided_arguments()
    {
        $result = $this->share->page(
            'https://mysite.com',
            'My share title',
            [
                'block_prefix' => '<ul>',
                'block_suffix' => '</ul>',
                'title' => 'link title',
                'class' => 'page-class',
                'id' => 'page-id',
                'rel' => 'nofollow',
            ])
            ->facebook()
            ->twitter(['title' => 'Provided title'])
            ->whatsapp()
            ->reddit(['id' => 'provided-id', 'class' => 'provided-class', 'rel' => 'provided'])
            ->telegram(['wrong' => null]);

        $expected = '<ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=My+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https%3A%2F%2Fmysite.com" class="social-button page-class" id="page-id" title="Provided title" rel="nofollow"><span class="fab fa-twitter"></span></a></li><li><a href="https://wa.me/?text=https%3A%2F%2Fmysite.com%20My+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow" target="_blank"><span class="fab fa-whatsapp"></span></a></li><li><a href="https://www.reddit.com/submit?title=My+share+title&url=https%3A%2F%2Fmysite.com" class="social-button provided-class" id="provided-id" title="link title" rel="provided"><span class="fab fa-reddit"></span></a></li><li><a href="https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=My+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow" target="_blank"><span class="fab fa-telegram"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }
}
