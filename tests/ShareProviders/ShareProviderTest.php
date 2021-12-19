<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders;

use Kudashevs\ShareButtons\Exceptions\InvalidShareProviderNameException;
use Kudashevs\ShareButtons\ShareProviders\Providers\CopyLink;
use Kudashevs\ShareButtons\ShareProviders\ShareProvider;
use PHPUnit\Framework\TestCase;

class ShareProviderTest extends TestCase
{
   /** @test */
    public function it_cannot_instanciate_by_wrong_name()
    {
        /**
         * We check it here just to be sure that the testing class is a right descendant.
         */
        $this->assertTrue(is_subclass_of(CopyLink::class, ShareProvider::class));

        $this->expectException(InvalidShareProviderNameException::class);
        $this->expectExceptionMessage('wrong');

        new CopyLink('wrong');
    }
}
