<?php

namespace Kudashevs\ShareButtons\Tests\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\Facades\ShareButtonsFacade;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class PinterestShareTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_pinterest_share_link()
    {
        $result = ShareButtonsFacade::page('https://mysite.com')->pinterest();
        $expected = '<div id="social-links"><ul><li><a href="https://pinterest.com/pin/create/button/?url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-pinterest"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_pinterest_share_link_with_a_custom_class()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', null, ['class' => 'my-class'])
            ->pinterest();
        $expected = '<div id="social-links"><ul><li><a href="https://pinterest.com/pin/create/button/?url=https://mysite.com" class="social-button my-class" id="" title="" rel=""><span class="fab fa-pinterest"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_pinterest_share_link_with_a_custom_class_and_custom_id()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', null, ['class' => 'my-class', 'id' => 'my-id'])
            ->pinterest();
        $expected = '<div id="social-links"><ul><li><a href="https://pinterest.com/pin/create/button/?url=https://mysite.com" class="social-button my-class" id="my-id" title="" rel=""><span class="fab fa-pinterest"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_pinterest_share_link_with_custom_prefix_and_suffix()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', null, [], '<ul>', '</ul>')
            ->pinterest();
        $expected = '<ul><li><a href="https://pinterest.com/pin/create/button/?url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-pinterest"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_pinterest_share_link_with_all_extra_options()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', 'title that is not used for fb', ['class' => 'my-class my-class2', 'id' => 'fb-share', 'title' => 'My Title for SEO', 'rel' => 'nofollow'], '<ul>', '</ul>')
            ->pinterest();
        $expected = '<ul><li><a href="https://pinterest.com/pin/create/button/?url=https://mysite.com" class="social-button my-class my-class2" id="fb-share" title="My Title for SEO" rel="nofollow"><span class="fab fa-pinterest"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }
}
