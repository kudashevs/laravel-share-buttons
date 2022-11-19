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
    public function it_can_retrieve_a_template()
    {
        $instance = LinkedIn::create();

        $this->assertNotEmpty($instance->getTemplate());
    }

    /** @test */
    public function it_can_retrieve_a_url()
    {
        $instance = LinkedIn::create();

        $this->assertNotEmpty($instance->getUrl());
    }

    /** @test */
    public function it_can_retrieve_a_text()
    {
        $instance = LinkedIn::create();

        $this->assertNotEmpty($instance->getText());
    }

    /** @test */
    public function it_can_retrieve_extras()
    {
        $instance = LinkedIn::create();

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
