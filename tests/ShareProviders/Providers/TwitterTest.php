<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\Facades\ShareButtonsFacade;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TwitterTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_twitter_share_link_with_default_share_text()
    {
        $result = ShareButtonsFacade::page('https://mysite.com')->twitter();
        $expected = '<div id="social-links"><ul><li><a href="https://twitter.com/intent/tweet?text=Default+share+text&url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-twitter"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_twitter_share_link_with_custom_share_text()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', 'Meet Joren Van Hocht a php developer with a passion for laravel')
            ->twitter();
        $expected = '<div id="social-links"><ul><li><a href="https://twitter.com/intent/tweet?text=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel&url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-twitter"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_facebook_share_link_with_a_custom_class()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', 'Meet Joren Van Hocht a php developer with a passion for laravel', ['class' => 'my-class'])
            ->twitter();
        $expected = '<div id="social-links"><ul><li><a href="https://twitter.com/intent/tweet?text=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel&url=https://mysite.com" class="social-button my-class" id="" title="" rel=""><span class="fab fa-twitter"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_twitter_share_link_with_a_custom_id()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', 'Meet Joren Van Hocht a php developer with a passion for laravel', ['id' => 'my-id'])
            ->twitter();
        $expected = '<div id="social-links"><ul><li><a href="https://twitter.com/intent/tweet?text=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel&url=https://mysite.com" class="social-button " id="my-id" title="" rel=""><span class="fab fa-twitter"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_twitter_share_link_with_a_custom_class_and_custom_id()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', 'Meet Joren Van Hocht a php developer with a passion for laravel', ['class' => 'my-class', 'id' => 'my-id'])
            ->twitter();
        $expected = '<div id="social-links"><ul><li><a href="https://twitter.com/intent/tweet?text=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel&url=https://mysite.com" class="social-button my-class" id="my-id" title="" rel=""><span class="fab fa-twitter"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_twitter_share_link_with_custom_prefix_and_suffix()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', null, [], '<ul>', '</ul>')
            ->twitter();
        $expected = '<ul><li><a href="https://twitter.com/intent/tweet?text=Default+share+text&url=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-twitter"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_twitter_share_link_with_all_extra_options()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', 'Meet Joren Van Hocht a php developer with a passion for laravel', ['class' => 'my-class', 'id' => 'my-id', 'title' => 'My Title for SEO', 'rel' => 'nofollow'], '<ul>', '</ul>')
            ->twitter();
        $expected = '<ul><li><a href="https://twitter.com/intent/tweet?text=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel&url=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-twitter"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }
}
