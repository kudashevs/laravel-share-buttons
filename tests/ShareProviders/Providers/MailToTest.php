<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\MailTo;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class MailToTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = MailTo::create();

        $this->assertEquals('mailto', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = MailTo::create();

        $this->assertEquals('Default share text', $provider->getText());
    }
}
