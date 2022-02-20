<?php

namespace Kudashevs\ShareButtons\Tests\ValueObjects;

use Kudashevs\ShareButtons\ValueObjects\ProcessedCall;
use PHPUnit\Framework\TestCase;

class ProcessedCallTest extends TestCase
{
    /** @test */
    public function it_can_throw_exception_when_empty_provider()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('share provider');

        new ProcessedCall('', 'https://mysite.com', []);
    }

    /** @test */
    public function it_can_throw_exception_when_empty_url()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('url');

        new ProcessedCall('facebook', '', []);
    }

    /** @test */
    public function it_creates_object_with_the_correct_state()
    {
        $provider = 'facebook';
        $url = 'https://mysite.com';
        $options = ['title' => 'test'];

        $VO = new ProcessedCall($provider, $url, $options);

        $this->assertSame($provider, $VO->getProvider());
        $this->assertSame($url, $VO->getUrl());
        $this->assertSame($options, $VO->getOptions());
    }
}
