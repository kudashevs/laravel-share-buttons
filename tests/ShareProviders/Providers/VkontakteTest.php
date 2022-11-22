<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Vkontakte;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class VkontakteTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = Vkontakte::create();

        $this->assertEquals('vkontakte', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = Vkontakte::create();

        $this->assertEquals('Default share text', $provider->getText());
    }
}
