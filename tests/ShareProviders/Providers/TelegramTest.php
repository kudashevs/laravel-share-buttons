<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\Facades\ShareButtonsFacade;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TelegramTest extends ExtendedTestCase
{
    public function provide_different_data_for_one_link()
    {
        return [

        ];
    }

    /** @test */
    public function it_can_generate_a_telegram_share_link_with_default_share_text()
    {
        $result = ShareButtonsFacade::page('https://mysite.com')->telegram();
        $expected = '<div id="social-links"><ul><li><a target="_blank" href="https://telegram.me/share/url?url=https://mysite.com&text=Default+share+text" class="social-button " id="" title="" rel=""><span class="fab fa-telegram"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_telegram_share_link_with_custom_share_text()
    {
        $result = ShareButtonsFacade::page('https://mysite.com',
            'Meet Joren Van Hocht a php developer with a passion for laravel')
            ->telegram();
        $expected = '<div id="social-links"><ul><li><a target="_blank" href="https://telegram.me/share/url?url=https://mysite.com&text=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel" class="social-button " id="" title="" rel=""><span class="fab fa-telegram"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_telegram_share_link_with_a_custom_class()
    {
        $result = ShareButtonsFacade::page('https://mysite.com',
            'Meet Joren Van Hocht a php developer with a passion for laravel', ['class' => 'my-class'])
            ->telegram();
        $expected = '<div id="social-links"><ul><li><a target="_blank" href="https://telegram.me/share/url?url=https://mysite.com&text=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel" class="social-button my-class" id="" title="" rel=""><span class="fab fa-telegram"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_telegram_share_link_with_a_custom_id()
    {
        $result = ShareButtonsFacade::page('https://mysite.com',
            'Meet Joren Van Hocht a php developer with a passion for laravel', ['id' => 'my-id'])
            ->telegram();
        $expected = '<div id="social-links"><ul><li><a target="_blank" href="https://telegram.me/share/url?url=https://mysite.com&text=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel" class="social-button " id="my-id" title="" rel=""><span class="fab fa-telegram"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_telegram_share_link_with_a_custom_class_and_custom_id()
    {
        $result = ShareButtonsFacade::page('https://mysite.com',
            'Meet Joren Van Hocht a php developer with a passion for laravel', ['class' => 'my-class', 'id' => 'my-id'])
            ->telegram();
        $expected = '<div id="social-links"><ul><li><a target="_blank" href="https://telegram.me/share/url?url=https://mysite.com&text=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel" class="social-button my-class" id="my-id" title="" rel=""><span class="fab fa-telegram"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_telegram_share_link_with_custom_prefix_and_suffix()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', '', ['prefix' => '<ul>', 'suffix' => '</ul>'])
            ->telegram();
        $expected = '<ul><li><a target="_blank" href="https://telegram.me/share/url?url=https://mysite.com&text=Default+share+text" class="social-button " id="" title="" rel=""><span class="fab fa-telegram"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_telegram_share_link_with_all_extra_options()
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
            ->telegram();
        $expected = '<ul><li><a target="_blank" href="https://telegram.me/share/url?url=https://mysite.com&text=Meet+Joren+Van+Hocht+a+php+developer+with+a+passion+for+laravel" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-telegram"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }
}
