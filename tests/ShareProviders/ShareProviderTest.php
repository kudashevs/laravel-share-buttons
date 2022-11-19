<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\Providers\LinkedIn;
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
        $instance = LinkedIn::create();

        $this->assertSame('linkedin', $instance->getName());
    }

    /** @test */
    public function it_can_retrieve_initial_values()
    {
        $instance = LinkedIn::create();

        $this->assertNotEmpty($instance->getTemplate());
        $this->assertNotEmpty($instance->getUrl());
        $this->assertNotEmpty($instance->getText());
        $this->assertNotEmpty($instance->getExtras());
    }

    /** @test */
    public function it_can_create_from_a_method_call()
    {
        $page = 'https://mysite.com';
        $title = 'Page share title';
        $arguments = [
            'rel' => 'nofollow',
        ];

        $instance = LinkedIn::createFromMethodCall($page, $title, $arguments);

        $this->assertNotEmpty($instance->getName());
        $this->assertNotEmpty($instance->getUrl());
    }
}
