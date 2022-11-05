<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProviderFactory;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class EvernoteTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = ShareProviderFactory::createFromName('evernote');

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://www.evernote.com/clip.action?url=https://mysite.com&t=Default+share+text';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title', []);
        $expected = 'https://www.evernote.com/clip.action?url=https://mysite.com&t=Title';

        $this->assertEquals($expected, $result);
    }
}
