<?php

namespace ShareButtons\Share\Test\Share;

use ShareButtons\Share\Facades\ShareFacade;
use ShareButtons\Share\Share;
use ShareButtons\Share\Test\ExtendedTestCase;

class ShareTest extends ExtendedTestCase
{
    private $share;

    protected function setUp(): void
    {
        $this->share = new Share();

        parent::setUp();
    }

    /** @test */
    public function it_creates_self_instance_on_page()
    {
        $this->assertInstanceOf(Share::class, $this->share->page('https://mysite.com'));
    }

    /** @test */
    public function it_create_self_instance_on_current_page()
    {
        $this->assertInstanceOf(Share::class, $this->share->currentPage());
    }

    /** @test */
    public function it_can_use_the_url_of_the_current_request()
    {
        $result = $this->share->currentPage()->facebook();
        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com/" class="social-button " id="" title="" rel=""><span class="fab fa-facebook-square"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }
}
