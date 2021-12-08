<?php

namespace Kudashevs\ShareButtons\Tests\Acceptance;

use Kudashevs\ShareButtons\Formatters\TranslateFormatter;
use Kudashevs\ShareButtons\ShareButtons;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class ShareButtonsTest extends ExtendedTestCase
{
    private $share;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to initialize a container

        $formatter = new TranslateFormatter();
        $this->share = new ShareButtons($formatter);
    }

    /**
     * @test
     * @dataProvider provide_different_share_providers_for_one_link
     */
    public function it_can_return_one_link_on_different_share_providers($media, $url, $title, $expected)
    {
        $result = $this->share->page($url, $title)
            ->$media()
            ->getRawLinks();

        $this->assertEquals([$media => $expected], $result);
    }

    /**
     * @todo don't forget to update these test cases
     */
    public function provide_different_share_providers_for_one_link()
    {
        return [
            'facebook' => [
                'facebook',
                'https://mysite.com',
                'My facebook title',
                'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com',
            ],
            'linkedin' => [
                'linkedin',
                'https://mysite.com',
                'My linkedin title',
                'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=My+linkedin+title&summary=',
            ],
            'pinterest' => [
                'pinterest',
                'https://mysite.com',
                'My pinterest title',
                'https://pinterest.com/pin/create/button/?url=https://mysite.com',
            ],
            'reddit' => [
                'reddit',
                'https://mysite.com',
                'My reddit title',
                'https://www.reddit.com/submit?title=My+reddit+title&url=https://mysite.com',
            ],
            'telegram' => [
                'telegram',
                'https://mysite.com',
                'My telegram title',
                'https://telegram.me/share/url?url=https://mysite.com&text=My+telegram+title',
            ],
            'twitter' => [
                'twitter',
                'https://mysite.com',
                'My twitter title',
                'https://twitter.com/intent/tweet?text=My+twitter+title&url=https://mysite.com',
            ],
            'whatsapp' => [
                'whatsapp',
                'https://mysite.com',
                'My whatsapp title',
                'https://wa.me/?text=https://mysite.com',
            ],
        ];
    }
}
