<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\Facades\ShareButtonsFacade;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class FacebookTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_facebook_share_link()
    {
        $result = ShareButtonsFacade::page('https://mysite.com')->facebook();
        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-facebook-square"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_facebook_share_link_with_a_custom_class()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', '', ['class' => 'my-class'])
            ->facebook();
        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button my-class" id="" title="" rel=""><span class="fab fa-facebook-square"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_facebook_share_link_with_a_custom_class_and_custom_id()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', '', ['class' => 'my-class', 'id' => 'my-id'])
            ->facebook();
        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button my-class" id="my-id" title="" rel=""><span class="fab fa-facebook-square"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_facebook_share_link_with_custom_prefix_and_suffix()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', '', ['prefix' => '<ul>', 'suffix' => '</ul>'])
            ->facebook();
        $expected = '<ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-facebook-square"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_facebook_share_link_with_all_extra_options()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', 'title that is not used for fb', [
            'prefix' => '<ul>',
            'suffix' => '</ul>',
            'class' => 'my-class my-class2',
            'id' => 'fb-share',
            'title' => 'My Title for SEO',
            'rel' => 'nofollow',
        ])
            ->facebook();
        $expected = '<ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button my-class my-class2" id="fb-share" title="My Title for SEO" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }
}
