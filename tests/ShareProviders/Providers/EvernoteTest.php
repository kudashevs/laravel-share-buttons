<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Evernote;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class EvernoteTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = Evernote::create();

        $this->assertEquals('evernote', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = Evernote::create();

        $this->assertEquals('Default share text', $provider->getText());
    }
}
