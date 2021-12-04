<?php

namespace ShareButtons\Share\Test\Share;

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
}
