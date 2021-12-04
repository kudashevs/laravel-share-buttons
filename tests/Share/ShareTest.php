<?php

namespace ShareButtons\Share\Test\Share;

use ShareButtons\Share\Share;
use ShareButtons\Share\Test\ExtendedTestCase;

class ShareTest extends ExtendedTestCase
{
    /** @test */
    public function it_creates_self_instance_on_page()
    {
        $this->assertInstanceOf(Share::class, (new Share())->page('https://mysite.com'));
    }
}
