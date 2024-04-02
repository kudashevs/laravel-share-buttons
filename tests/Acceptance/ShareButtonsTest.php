<?php

namespace Kudashevs\ShareButtons\Tests\Acceptance;

use BadMethodCallException;
use Kudashevs\ShareButtons\Facades\ShareButtonsFacade;
use Kudashevs\ShareButtons\ShareButtons;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class ShareButtonsTest extends ExtendedTestCase
{
    private ShareButtons $share;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->share = new ShareButtons();
    }

    /** @test */
    public function an_instance_can_throw_an_exception_when_a_wrong_button_name(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('ShareButtons::wrong()');

        $instance = new ShareButtons();
        $instance->page('https://mysite.com')->wrong()->getRawLinks();
    }

    /** @test */
    public function a_facade_can_throw_an_exception_when_a_wrong_button_name(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('ShareButtons::wrong()');

        ShareButtonsFacade::page('https://mysite.com')->wrong()->getRawLinks();
    }

    /** @test */
    public function an_instance_can_generate_one_share_button_url(): void
    {
        $rawLinks = $this->share->page('https://mysite.com')
            ->twitter()
            ->getRawLinks();

        $this->assertNotEmpty($rawLinks);
        $this->assertStringContainsString('twitter', current($rawLinks));
    }

    /** @test */
    public function a_facade_can_generate_one_share_button_url(): void
    {
        $rawLinks = ShareButtonsFacade::page('https://mysite.com')
            ->twitter()
            ->getRawLinks();

        $this->assertNotEmpty($rawLinks);
        $this->assertStringContainsString('twitter', current($rawLinks));
    }

    /** @test */
    public function an_instance_can_generate_one_share_button_link(): void
    {
        $readyHtml = $this->share->page('https://mysite.com')
            ->twitter()
            ->getShareButtons();

        $this->assertMatchesRegularExpression('/href.*twitter/', $readyHtml);
    }

    /** @test */
    public function a_facade_can_generate_one_share_button_link(): void
    {
        $readyHtml = ShareButtonsFacade::page('https://mysite.com')
            ->twitter()
            ->getShareButtons();

        $this->assertMatchesRegularExpression('/href.*twitter/', $readyHtml);
    }

    /**
     * @test
     * @dataProvider provideDifferentShareButtonsValues
     */
    public function it_can_generate_an_expected_share_button(
        string $media,
        string $url,
        string $title,
        string $expected
    ): void {
        $readyHtml = $this->share->page($url, $title)
            ->$media()
            ->getShareButtons();

        $this->assertStringContainsString($expected, $readyHtml);
    }

    /**
     * @todo don't forget to update these test cases
     */
    public static function provideDifferentShareButtonsValues(): array
    {
        return [
            'copylink' => [
                'copylink',
                'https://mysite.com',
                'My copylink title',
                'https://mysite.com',
            ],
            'evernote' => [
                'evernote',
                'https://mysite.com',
                'My evernote title',
                'https://www.evernote.com/clip.action?url=https%3A%2F%2Fmysite.com&t=My+evernote+title',
            ],
            'facebook' => [
                'facebook',
                'https://mysite.com',
                'My facebook title',
                'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=My+facebook+title',
            ],
            'hackernews' => [
                'hackernews',
                'https://mysite.com',
                'My hacker news title',
                'https://news.ycombinator.com/submitlink?t=My+hacker+news+title&u=https%3A%2F%2Fmysite.com',
            ],
            'linkedin' => [
                'linkedin',
                'https://mysite.com',
                'My linkedin title',
                'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=My+linkedin+title&summary=',
            ],
            'mailto' => [
                'mailto',
                'https://mysite.com',
                'My share by mail title',
                'mailto:?subject=My+share+by+mail+title&body=https%3A%2F%2Fmysite.com',
            ],
            'pinterest' => [
                'pinterest',
                'https://mysite.com',
                'My pinterest title',
                'https://pinterest.com/pin/create/button/?url=https%3A%2F%2Fmysite.com',
            ],
            'pocket' => [
                'pocket',
                'https://mysite.com',
                'My pocket title',
                'https://getpocket.com/edit?url=https%3A%2F%2Fmysite.com&title=My+pocket+title',
            ],
            'reddit' => [
                'reddit',
                'https://mysite.com',
                'My reddit title',
                'https://www.reddit.com/submit?title=My+reddit+title&url=https%3A%2F%2Fmysite.com',
            ],
            'skype' => [
                'skype',
                'https://mysite.com',
                'My skype title',
                'https://web.skype.com/share?url=https%3A%2F%2Fmysite.com&text=My+skype+title&source=button',
            ],
            'telegram' => [
                'telegram',
                'https://mysite.com',
                'My telegram title',
                'https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=My+telegram+title',
            ],
            'twitter' => [
                'twitter',
                'https://mysite.com',
                'My twitter title',
                'https://twitter.com/intent/tweet?text=My+twitter+title&url=https%3A%2F%2Fmysite.com',
            ],
            'vkontakte' => [
                'vkontakte',
                'https://mysite.com',
                'My vkontakte title',
                'https://vk.com/share.php?url=https%3A%2F%2Fmysite.com&title=My+vkontakte+title',
            ],
            'whatsapp' => [
                'whatsapp',
                'https://mysite.com',
                'My whatsapp title',
                'https://wa.me/?text=https%3A%2F%2Fmysite.com%20My+whatsapp+title',
            ],
            'xing' => [
                'xing',
                'https://mysite.com',
                'My xing title',
                'https://www.xing.com/spi/shares/new?url=https%3A%2F%2Fmysite.com',
            ],
        ];
    }
}
