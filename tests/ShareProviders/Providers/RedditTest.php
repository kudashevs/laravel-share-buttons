<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\Facades\ShareButtonsFacade;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class RedditTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_reddit_share_link_with_default_share_text()
    {
        $result = ShareButtonsFacade::page('https://mysite.com')->reddit();
        $expected = '<div id="social-links"><ul><li><a href="https://www.reddit.com/submit?title=Default+share+text&url=https://mysite.com" class="social-button" target="_blank"><span class="fab fa-reddit"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_reddit_share_link_with_custom_share_text()
    {
        $result = ShareButtonsFacade::page('https://mysite.com',
            'Meet Joren Van Hocht a php developer with a passion for laravel')
            ->reddit();
        $expected = '<div id="social-links"><ul><li><a href="https://www.reddit.com/submit?title=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel&url=https://mysite.com" class="social-button" target="_blank"><span class="fab fa-reddit"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_reddit_share_link_with_a_custom_class()
    {
        $result = ShareButtonsFacade::page('https://mysite.com',
            'Meet Joren Van Hocht a php developer with a passion for laravel', ['class' => 'my-class'])
            ->reddit();
        $expected = '<div id="social-links"><ul><li><a href="https://www.reddit.com/submit?title=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel&url=https://mysite.com" class="social-button my-class" target="_blank"><span class="fab fa-reddit"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_reddit_share_link_with_a_custom_id()
    {
        $result = ShareButtonsFacade::page('https://mysite.com',
            'Meet Joren Van Hocht a php developer with a passion for laravel', ['id' => 'my-id'])
            ->reddit();
        $expected = '<div id="social-links"><ul><li><a href="https://www.reddit.com/submit?title=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel&url=https://mysite.com" class="social-button" id="my-id" target="_blank"><span class="fab fa-reddit"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_reddit_share_link_with_a_custom_class_and_custom_id()
    {
        $result = ShareButtonsFacade::page('https://mysite.com',
            'Meet Joren Van Hocht a php developer with a passion for laravel', ['class' => 'my-class', 'id' => 'my-id'])
            ->reddit();
        $expected = '<div id="social-links"><ul><li><a href="https://www.reddit.com/submit?title=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel&url=https://mysite.com" class="social-button my-class" id="my-id" target="_blank"><span class="fab fa-reddit"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_reddit_share_link_with_custom_prefix_and_suffix()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', '', ['prefix' => '<ul>', 'suffix' => '</ul>'])
            ->reddit();
        $expected = '<ul><li><a href="https://www.reddit.com/submit?title=Default+share+text&url=https://mysite.com" class="social-button" target="_blank"><span class="fab fa-reddit"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_reddit_share_link_with_all_extra_options()
    {
        $result = ShareButtonsFacade::page('https://mysite.com',
            'Meet Joren Van Hocht a php developer with a passion for laravel', [
                'prefix' => '<ul>',
                'suffix' => '</ul>',
                'class' => 'my-class',
                'id' => 'my-id',
                'title' => 'My Title for SEO',
                'rel' => 'nofollow',
            ])
            ->reddit();
        $expected = '<ul><li><a href="https://www.reddit.com/submit?title=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel&url=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow" target="_blank"><span class="fab fa-reddit"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }
}
