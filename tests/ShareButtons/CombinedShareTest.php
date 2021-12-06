<?php

namespace Kudashevs\ShareButtons\Tests\ShareButtons;

use Kudashevs\ShareButtons\Facades\ShareButtonsFacade;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class CombinedShareTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_generate_multiple_share_links_at_once()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', 'My share title')
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->pinterest()
            ->reddit()
            ->telegram();

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-twitter"></span></a></li><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+share+title&summary=" class="social-button " id="" title="" rel=""><span class="fab fa-linkedin"></span></a></li><li><a target="_blank" href="https://wa.me/?text=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-whatsapp"></span></a></li><li><a href="https://pinterest.com/pin/create/button/?url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-pinterest"></span></a></li><li><a target="_blank" href="https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-reddit"></span></a></li><li><a target="_blank" href="https://telegram.me/share/url?url=https://mysite.com&text=My+share+title" class="social-button " id="" title="" rel=""><span class="fab fa-telegram"></span></a></li></ul></div>';
        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_multiple_share_links_at_once_and_multiple_times_after_each_other()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', 'My share title')
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->pinterest()
            ->reddit()
            ->telegram();

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-twitter"></span></a></li><li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+share+title&summary=" class="social-button " id="" title="" rel=""><span class="fab fa-linkedin"></span></a></li><li><a target="_blank" href="https://wa.me/?text=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-whatsapp"></span></a></li><li><a href="https://pinterest.com/pin/create/button/?url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-pinterest"></span></a></li><li><a target="_blank" href="https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-reddit"></span></a></li><li><a target="_blank" href="https://telegram.me/share/url?url=https://mysite.com&text=My+share+title" class="social-button " id="" title="" rel=""><span class="fab fa-telegram"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);

        $result = ShareButtonsFacade::page('https://mysite.com', 'My share title')
            ->facebook()
            ->twitter();

        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-twitter"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_generate_multiple_share_links_at_once_with_extra_options()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', 'My share title', ['class' => 'my-class', 'id' => 'my-id', 'title' => 'My Title for SEO', 'rel' => 'nofollow'], '<ul>', '</ul>')
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->pinterest()
            ->reddit()
            ->telegram();

        $expected = '<ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li><li><a href="https://twitter.com/intent/tweet?text=My+share+title&url=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-twitter"></span></a></li><li><a target="_blank" href="https://wa.me/?text=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-whatsapp"></span></a></li><li><a href="https://pinterest.com/pin/create/button/?url=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-pinterest"></span></a></li><li><a target="_blank" href="https://www.reddit.com/submit?title=My+share+title&url=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-reddit"></span></a></li><li><a target="_blank" href="https://telegram.me/share/url?url=https://mysite.com&text=My+share+title" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-telegram"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }
}
