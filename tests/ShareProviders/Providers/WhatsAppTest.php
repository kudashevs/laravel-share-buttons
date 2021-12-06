<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\Facades\ShareButtonsFacade;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class WhatsAppTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_whatsapp_share_link_with_default_share_text()
    {
        $result = ShareButtonsFacade::page('https://mysite.com')->whatsapp();
        $expected = '<div id="social-links"><ul><li><a target="_blank" href="https://wa.me/?text=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-whatsapp"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_whatsapp_share_link_with_a_custom_class()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', '', ['class' => 'my-class'])
            ->whatsapp();
        $expected = '<div id="social-links"><ul><li><a target="_blank" href="https://wa.me/?text=https://mysite.com" class="social-button my-class" id="" title="" rel=""><span class="fab fa-whatsapp"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_whatsapp_share_link_with_a_custom_id()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', '', ['id' => 'my-id'])
            ->whatsapp();
        $expected = '<div id="social-links"><ul><li><a target="_blank" href="https://wa.me/?text=https://mysite.com" class="social-button " id="my-id" title="" rel=""><span class="fab fa-whatsapp"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_whatsapp_share_link_with_a_custom_class_and_custom_id()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', '', ['class' => 'my-class', 'id' => 'my-id'])
            ->whatsapp();
        $expected = '<div id="social-links"><ul><li><a target="_blank" href="https://wa.me/?text=https://mysite.com" class="social-button my-class" id="my-id" title="" rel=""><span class="fab fa-whatsapp"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_whatsapp_share_link_with_custom_prefix_and_suffix()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', '', ['prefix' => '<ul>', 'suffix' => '</ul>'])
            ->whatsapp();
        $expected = '<ul><li><a target="_blank" href="https://wa.me/?text=https://mysite.com" class="social-button " id="" title="" rel=""><span class="fab fa-whatsapp"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }

    /** @test */
    public function it_can_generate_a_whatsapp_share_link_with_all_extra_options()
    {
        $result = ShareButtonsFacade::page('https://mysite.com', '', [
            'prefix' => '<ul>',
            'suffix' => '</ul>',
            'class' => 'my-class',
            'id' => 'my-id',
            'title' => 'My Title for SEO',
            'rel' => 'nofollow',
        ])
            ->whatsapp();
        $expected = '<ul><li><a target="_blank" href="https://wa.me/?text=https://mysite.com" class="social-button my-class" id="my-id" title="My Title for SEO" rel="nofollow"><span class="fab fa-whatsapp"></span></a></li></ul>';

        $this->assertEquals($expected, (string)$result);
    }
}
