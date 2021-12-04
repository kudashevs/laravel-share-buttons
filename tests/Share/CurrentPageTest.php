<?php

namespace ShareButtons\Share\Test\Share;

use ShareButtons\Share\Facades\ShareFacade;
use ShareButtons\Share\Test\ExtendedTestCase;

class CurrentPageTest extends ExtendedTestCase
{
    /**
     * @test
     */
    public function it_can_use_the_url_of_the_current_request()
    {
        $result = ShareFacade::currentPage()->facebook();
        $expected = '<div id="social-links"><ul><li><a href="https://www.facebook.com/sharer/sharer.php?u=http://mysite.com/" class="social-button " id="" title="" rel=""><span class="fab fa-facebook-square"></span></a></li></ul></div>';

        $this->assertEquals($expected, (string)$result);
    }
}
