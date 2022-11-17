<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class ShareProviderTest extends ExtendedTestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application
    }

    /** @test */
    public function it_can_create_an_instance()
    {
        $instance = Facebook::create();

        $this->assertNotEmpty($instance->getName());
        $this->assertNotEmpty($instance->getUrl());
        $this->assertIsArray($instance->getArguments());
    }

    /** @test */
    public function it_can_create_from_a_method_call()
    {
        $page = 'https://mysite.com';
        $title = 'Page share title';
        $arguments = [
            'rel' => 'nofollow',
        ];

        $instance = Facebook::createFromMethodCall($page, $title, $arguments);

        $this->assertNotEmpty($instance->getName());
        $this->assertNotEmpty($instance->getUrl());
        $this->assertIsArray($instance->getArguments());
    }
}
