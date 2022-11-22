<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Telegram;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TelegramTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = Telegram::create();

        $this->assertEquals('telegram', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = Telegram::create();

        $this->assertEquals('Default share text', $provider->getText());
    }
}
