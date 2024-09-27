<?php

namespace Kudashevs\ShareButtons\Tests\Unit;

use Illuminate\Http\Request;
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
    public function it_can_throw_an_exception_when_a_wrong_share_button_name(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('ShareButtons::wrong()');

        $instance = new ShareButtons();
        $instance->page('https://mysite.com')->wrong()->getRawLinks();
    }

    /** @test */
    public function it_can_return_self_instance_from_page_method(): void
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->page('https://mysite.com'));
    }

    /** @test */
    public function it_can_return_self_instance_from_current_page_method(): void
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->currentPage());
    }

    /** @test */
    public function it_can_return_self_instance_from_create_for_page_method(): void
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->createForPage('https://mysite.com'));
    }

    /** @test */
    public function it_can_return_self_instance_from_create_for_current_page_method(): void
    {
        $this->assertInstanceOf(ShareButtons::class, $this->share->createForCurrentPage());
    }

    /** @test */
    public function it_can_be_stringified(): void
    {
        $instance = $this->share->page('https://mysite.com', 'any')->linkedin();

        $this->assertInstanceOf(\Stringable::class, $instance);
        $this->assertStringContainsString('linkedin', (string)$instance);
    }

    /** @test */
    public function it_can_create_one_link_with_a_predefined_title(): void
    {
        $title = config('share-buttons.buttons.twitter.text');
        $expected = urlencode($title);

        $instance = $this->share->page('https://mysite.com')->twitter();

        $this->assertStringContainsString($expected, (string)$instance);
    }

    /** @test */
    public function it_can_create_one_link_with_a_provided_title(): void
    {
        $title = 'Page title';
        $expected = urlencode($title);

        $instance = $this->share->page('https://mysite.com', $title)->twitter();

        $this->assertStringContainsString($expected, (string)$instance);
    }

    /** @test */
    public function it_can_return_one_correct_link_from_page_method(): void
    {
        $instance = $this->share->page('https://mysite.com')->facebook();

        $this->assertStringContainsString('mysite.com', (string)$instance);
        $this->assertStringContainsString('facebook', (string)$instance);
    }

    /** @test */
    public function it_can_return_one_correct_link_from_current_page_method(): void
    {
        $this->stubRequestUrl('https://mysite.com');

        $instance = $this->share->currentPage()->facebook();

        $this->assertStringContainsString('mysite.com', (string)$instance);
        $this->assertStringContainsString('facebook', (string)$instance);
    }

    /** @test */
    public function it_can_return_one_correct_link_from_create_for_page_method(): void
    {
        $instance = $this->share->createForPage('https://mysite.com')->twitter();

        $this->assertStringContainsString('mysite.com', (string)$instance);
        $this->assertStringContainsString('twitter', (string)$instance);
    }

    /** @test */
    public function it_can_return_one_correct_link_from_create_for_current_page_method(): void
    {
        $this->stubRequestUrl('https://mysite.com');

        $instance = $this->share->createForCurrentPage()->twitter();

        $this->assertStringContainsString('mysite.com', (string)$instance);
        $this->assertStringContainsString('twitter', (string)$instance);
    }

    /** @test */
    public function it_returns_empty_from_get_raw_links_method_when_no_calls_provided(): void
    {
        $rawLinks = $this->share->page('https://mysite.com', 'My share title')
            ->getRawLinks();

        $this->assertIsArray($rawLinks);
        $this->assertEmpty($rawLinks);
    }

    /** @test */
    public function it_can_return_one_link_from_get_raw_links_method(): void
    {
        $rawLinks = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->getRawLinks();

        $this->assertIsArray($rawLinks);
        $this->assertNotEmpty($rawLinks);
    }

    /** @test */
    public function it_can_return_multiple_links_at_once_from_get_raw_links_method(): void
    {
        $rawLinks = $this->share->page('https://mysite.com', 'My share title')
            ->twitter()
            ->reddit()
            ->telegram()
            ->getRawLinks();

        $this->assertCount(3, $rawLinks);
        $this->assertStringContainsString('twitter', $rawLinks['twitter']);
        $this->assertStringContainsString('reddit', $rawLinks['reddit']);
        $this->assertStringContainsString('telegram', $rawLinks['telegram']);
    }

    /** @test */
    public function it_returns_empty_when_cast_to_string_and_no_calls_provided(): void
    {
        $instance = $this->share->page('https://mysite.com', 'My share title');

        $this->assertStringContainsString('', (string)$instance);
    }

    /** @test */
    public function it_can_return_one_link_when_cast_to_string(): void
    {
        $instance = $this->share->page('https://mysite.com', 'My share title')
            ->facebook();

        $this->assertStringContainsString('facebook', (string)$instance);
    }

    /** @test */
    public function it_can_return_multiple_links_when_cast_to_string(): void
    {
        $instance = $this->share->page('https://mysite.com', 'My share title')
            ->twitter()
            ->reddit()
            ->telegram();

        $this->assertStringContainsString('twitter', (string)$instance);
        $this->assertStringContainsString('reddit', (string)$instance);
        $this->assertStringContainsString('telegram', (string)$instance);
    }

    /** @test */
    public function it_returns_empty_from_render_method_when_no_calls_provided(): void
    {
        $readyHtml = $this->share->page('https://mysite.com', 'My share title')
            ->render();

        $this->assertStringContainsString('', $readyHtml);
    }

    /** @test */
    public function it_can_return_one_link_from_render_method(): void
    {
        $readyHtml = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->render();

        $this->assertStringContainsString('facebook', $readyHtml);
    }

    /** @test */
    public function it_can_return_multiple_links_from_render_method(): void
    {
        $readyHtml = $this->share->page('https://mysite.com', 'My share title')
            ->twitter()
            ->reddit()
            ->telegram()
            ->render();

        $expectedLinks = [
            '<a href="https://twitter.com/intent/tweet?text=My+share+title&url=https%3A%2F%2Fmysite.com" class="social-button"><span class="fab fa-square-x-twitter"></span></a>',
            '<a href="https://www.reddit.com/submit?title=My+share+title&url=https%3A%2F%2Fmysite.com" class="social-button"><span class="fab fa-reddit"></span></a>',
            '<a href="https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=My+share+title" class="social-button" target="_blank"><span class="fab fa-telegram"></span></a>',
        ];

        $this->assertStringContainsStrings($expectedLinks, $readyHtml);
    }

    /** @test */
    public function it_returns_empty_from_get_share_buttons_method_when_no_calls_provided(): void
    {
        $readyHtml = $this->share->page('https://mysite.com', 'My share title')
            ->getShareButtons();

        $this->assertStringContainsString('', $readyHtml);
    }

    /** @test */
    public function it_can_return_one_link_from_get_share_buttons_method(): void
    {
        $readyHtml = $this->share->page('https://mysite.com', 'My share title')
            ->facebook()
            ->getShareButtons();

        $this->assertStringContainsString('facebook', $readyHtml);
    }

    /** @test */
    public function it_can_return_multiple_links_from_get_share_buttons_method(): void
    {
        $readyHtml = $this->share->page('https://mysite.com', 'My share title')
            ->twitter()
            ->reddit()
            ->telegram()
            ->getShareButtons();

        $expectedLinks = [
            '<a href="https://twitter.com/intent/tweet?text=My+share+title&url=https%3A%2F%2Fmysite.com" class="social-button"><span class="fab fa-square-x-twitter"></span></a>',
            '<a href="https://www.reddit.com/submit?title=My+share+title&url=https%3A%2F%2Fmysite.com" class="social-button"><span class="fab fa-reddit"></span></a>',
            '<a href="https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=My+share+title" class="social-button" target="_blank"><span class="fab fa-telegram"></span></a>',
        ];

        $this->assertStringContainsStrings($expectedLinks, $readyHtml);
    }

    /** @test */
    public function it_can_return_multiple_links_and_then_multiple_links_another_time(): void
    {
        $readyHtml = $this->share->page('https://mysite.com', 'My first title')
            ->facebook()
            ->twitter()
            ->linkedin()
            ->render();

        $expectedLinks = [
            '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=My+first+title" class="social-button"><span class="fab fa-facebook-square"></span></a>',
            '<a href="https://twitter.com/intent/tweet?text=My+first+title&url=https%3A%2F%2Fmysite.com" class="social-button"><span class="fab fa-square-x-twitter"></span></a>',
            '<a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=My+first+title&summary=" class="social-button"><span class="fab fa-linkedin"></span></a>',
        ];

        $this->assertStringContainsStrings($expectedLinks, $readyHtml);

        $readyHtml = $this->share->page('https://mysite.com', 'My second title')
            ->reddit()
            ->telegram()
            ->render();

        $expectedLinks = [
            '<a href="https://www.reddit.com/submit?title=My+second+title&url=https%3A%2F%2Fmysite.com" class="social-button"><span class="fab fa-reddit"></span></a>',
            '<a href="https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=My+second+title" class="social-button" target="_blank"><span class="fab fa-telegram"></span></a>',
        ];

        $this->assertStringContainsStrings($expectedLinks, $readyHtml);
    }

    /** @test */
    public function it_can_return_multiple_links_with_extra_options(): void
    {
        $readyHtml = $this->share->page(
            'https://mysite.com',
            'Page share title',
            [
                'block_prefix' => '',
                'block_suffix' => '',
                'element_prefix' => '<div>',
                'element_suffix' => '</div>',
                'title' => 'link title',
                'class' => 'page-class',
                'id' => 'page-id',
                'rel' => 'nofollow',
            ])
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->reddit()
            ->telegram()
            ->render();

        $expectedHtml = '<div><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Page+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow"><span class="fab fa-facebook-square"></span></a></div>'
            . '<div><a href="https://twitter.com/intent/tweet?text=Page+share+title&url=https%3A%2F%2Fmysite.com" class="social-button page-class" id="page-id" title="link title" rel="nofollow"><span class="fab fa-square-x-twitter"></span></a></div>'
            . '<div><a href="https://wa.me/?text=https%3A%2F%2Fmysite.com%20Page+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow" target="_blank"><span class="fab fa-square-whatsapp"></span></a></div>'
            . '<div><a href="https://www.reddit.com/submit?title=Page+share+title&url=https%3A%2F%2Fmysite.com" class="social-button page-class" id="page-id" title="link title" rel="nofollow"><span class="fab fa-reddit"></span></a></div>'
            . '<div><a href="https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=Page+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow" target="_blank"><span class="fab fa-telegram"></span></a></div>';

        $this->assertEquals($expectedHtml, $readyHtml);
    }

    /** @test */
    public function it_can_return_multiple_links_with_provided_arguments(): void
    {
        $readyHtml = $this->share->page('https://mysite.com', 'Page share title')
            ->facebook(['rel' => 'nofollow'])
            ->linkedin(['summary' => 'Test summary', 'class' => 'active'])
            ->twitter(['rel' => 'follow'])
            ->render();

        $expectedLinks = [
            '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Page+share+title" class="social-button" rel="nofollow"><span class="fab fa-facebook-square"></span></a>',
            '<a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=Page+share+title&summary=Test+summary" class="social-button active"><span class="fab fa-linkedin"></span></a>',
            '<a href="https://twitter.com/intent/tweet?text=Page+share+title&url=https%3A%2F%2Fmysite.com" class="social-button" rel="follow"><span class="fab fa-square-x-twitter"></span></a>',
        ];

        $this->assertStringContainsStrings($expectedLinks, $readyHtml);
    }

    /** @test */
    public function it_can_return_multiple_links_with_extra_options_and_provided_arguments(): void
    {
        $readyHtml = $this->share->page(
            'https://mysite.com',
            'My share title',
            [
                'block_prefix' => '<ul>',
                'block_suffix' => '</ul>',
                'element_prefix' => '<li>',
                'element_suffix' => '</li>',
                'title' => 'link title',
                'class' => 'page-class',
                'id' => 'page-id',
                'rel' => 'nofollow',
            ])
            ->facebook()
            ->twitter(['title' => 'Provided title'])
            ->whatsapp()
            ->reddit(['id' => 'provided-id', 'class' => 'provided-class', 'rel' => 'provided'])
            ->telegram(['wrong' => null])
            ->render();

        $expectedHtml = '<ul>'
            . '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=My+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li>'
            . '<li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https%3A%2F%2Fmysite.com" class="social-button page-class" id="page-id" title="Provided title" rel="nofollow"><span class="fab fa-square-x-twitter"></span></a></li>'
            . '<li><a href="https://wa.me/?text=https%3A%2F%2Fmysite.com%20My+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow" target="_blank"><span class="fab fa-square-whatsapp"></span></a></li>'
            . '<li><a href="https://www.reddit.com/submit?title=My+share+title&url=https%3A%2F%2Fmysite.com" class="social-button provided-class" id="provided-id" title="link title" rel="provided"><span class="fab fa-reddit"></span></a></li>'
            . '<li><a href="https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=My+share+title" class="social-button page-class" id="page-id" title="link title" rel="nofollow" target="_blank"><span class="fab fa-telegram"></span></a></li>'
            . '</ul>';

        $this->assertEquals($expectedHtml, $readyHtml);
    }

    private function stubRequestUrl(string $url): void
    {
        $request = Request::create($url);

        $request->setRouteResolver(function () use ($request) {
            return (new \Illuminate\Routing\Route('GET', '/', []))->bind($request);
        });

        $this->instance(Request::class, $request);
        $this->instance('request', $request);
    }

    /**
     * @param array<array-key, string> $needles
     * @param string $haystack
     */
    private function assertStringContainsStrings(array $needles, string $haystack): void
    {
        foreach ($needles as $needle) {
            $this->assertStringContainsString($needle, $haystack);
        }
    }
}
