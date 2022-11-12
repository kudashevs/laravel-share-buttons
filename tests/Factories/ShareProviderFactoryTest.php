<?php

namespace Kudashevs\ShareButtons\Tests\Factories;

use Kudashevs\ShareButtons\Exceptions\InvalidFactoryArgumentException;
use Kudashevs\ShareButtons\Factories\ShareProviderFactory;
use Kudashevs\ShareButtons\ShareProviders\Providers\CopyLink;
use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use PHPUnit\Framework\TestCase;

class ShareProviderFactoryTest extends TestCase
{
    /** @test */
    public function it_can_throw_exception_when_an_unknown_name_is_provided()
    {
        $this->expectException(InvalidFactoryArgumentException::class);
        $this->expectExceptionMessage('wrong');

        ShareProviderFactory::createFromName('wrong');
    }

    /** @test */
    public function it_can_validate_a_share_provider_by_name()
    {
        $this->assertTrue(ShareProviderFactory::isValidProviderName('facebook'));
        $this->assertFalse(ShareProviderFactory::isValidProviderName('wrong'));
    }

    /** @test */
    public function it_can_validate_a_share_provider_by_name_and_class()
    {
        $this->assertTrue(ShareProviderFactory::isValidProvider('copylink', CopyLink::class));
        $this->assertFalse(ShareProviderFactory::isValidProvider('copylink', Facebook::class));
    }

    /** @test */
    public function it_can_create_a_specific_instance_from_a_known_name()
    {
        $provider = ShareProviderFactory::createFromName('facebook');

        $this->assertInstanceOf(Facebook::class, $provider);
    }
}
