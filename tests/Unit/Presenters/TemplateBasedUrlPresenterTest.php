<?php

namespace Kudashevs\ShareButtons\Tests\Unit\Presenters;

use Kudashevs\ShareButtons\Presenters\TemplateBasedUrlPresenter;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TemplateBasedUrlPresenterTest extends ExtendedTestCase
{
    private TemplateBasedUrlPresenter $presenter;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->presenter = new TemplateBasedUrlPresenter();
    }

    /** @test */
    public function it_can_generate_an_empty_url_when_wrong_name(): void
    {
        $generatedUrl = $this->presenter->generateUrl('wrong', []);

        $this->assertSame('', $generatedUrl);
    }

    /**
     * @test
     * @dataProvider provideDifferentShareButtonsValues
     */
    public function it_can_generate_a_url(string $name, array $arguments, string $expected): void
    {
        $generatedUrl = $this->presenter->generateUrl($name, $arguments);

        $this->assertSame($expected, $generatedUrl);
    }

    public static function provideDifferentShareButtonsValues(): array
    {
        return [
            'copylink button remains raw' => [
                'copylink',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://mysite.com',
            ],
            'evernote button without text results in the default text' => [
                'evernote',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://www.evernote.com/clip.action?url=https%3A%2F%2Fmysite.com&t=Default+share+text',
            ],
            'evernote button with text results in the provided text' => [
                'evernote',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My evernote title',
                ],
                'https://www.evernote.com/clip.action?url=https%3A%2F%2Fmysite.com&t=My+evernote+title',
            ],
            'facebook button without text results in the default text' => [
                'facebook',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Default+share+text',
            ],
            'facebook button with text results in the provided text' => [
                'facebook',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My facebook title',
                ],
                'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=My+facebook+title',
            ],
            'hackernews button without text results in the default text' => [
                'hackernews',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://news.ycombinator.com/submitlink?t=Default+share+text&u=https%3A%2F%2Fmysite.com',
            ],
            'hackernews button with text results in the provided text' => [
                'hackernews',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My hacker news title',
                ],
                'https://news.ycombinator.com/submitlink?t=My+hacker+news+title&u=https%3A%2F%2Fmysite.com',
            ],
            'linkedin button without text results in the default text' => [
                'linkedin',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=Default+share+text&summary=',
            ],
            'linkedin button with text results in the provided text' => [
                'linkedin',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My linkedin title',
                ],
                'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=My+linkedin+title&summary=',
            ],
            'linkedin button with text and summary results in the provided text and summary' => [
                'linkedin',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My linkedin title',
                    'summary' => 'Text summary',
                ],
                'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=My+linkedin+title&summary=Text+summary',
            ],
            'mailto button without text results in the default text' => [
                'mailto',
                [
                    'url' => 'https://mysite.com',
                ],
                'mailto:?subject=Default+share+text&body=https%3A%2F%2Fmysite.com',
            ],
            'mailto button with text results in the provided text' => [
                'mailto',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My share by mail title',
                ],
                'mailto:?subject=My+share+by+mail+title&body=https%3A%2F%2Fmysite.com',
            ],
            'pinterest button with text results in without text' => [
                'pinterest',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My pinterest title',
                ],
                'https://pinterest.com/pin/create/button/?url=https%3A%2F%2Fmysite.com',
            ],
            'pocket button without text results in the default text' => [
                'pocket',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://getpocket.com/edit?url=https%3A%2F%2Fmysite.com&title=Default+share+text',
            ],
            'pocket button with text results in the provided text' => [
                'pocket',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My pocket title',
                ],
                'https://getpocket.com/edit?url=https%3A%2F%2Fmysite.com&title=My+pocket+title',
            ],
            'reddit button without text results in the default text' => [
                'reddit',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://www.reddit.com/submit?title=Default+share+text&url=https%3A%2F%2Fmysite.com',
            ],
            'reddit button with text results in the provided text' => [
                'reddit',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My reddit title',
                ],
                'https://www.reddit.com/submit?title=My+reddit+title&url=https%3A%2F%2Fmysite.com',
            ],
            'skype button without text results in the default text' => [
                'skype',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://web.skype.com/share?url=https%3A%2F%2Fmysite.com&text=Default+share+text&source=button',
            ],
            'skype button with text results in the provided text' => [
                'skype',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My skype title',
                ],
                'https://web.skype.com/share?url=https%3A%2F%2Fmysite.com&text=My+skype+title&source=button',
            ],
            'telegram button without text results in the default text' => [
                'telegram',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=Default+share+text',
            ],
            'telegram button with text results in the provided text' => [
                'telegram',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My telegram title',
                ],
                'https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=My+telegram+title',
            ],
            'twitter button without text results in the default text' => [
                'twitter',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://twitter.com/intent/tweet?text=Default+share+text&url=https%3A%2F%2Fmysite.com',
            ],
            'twitter button with text results in the provided text' => [
                'twitter',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My twitter title',
                ],
                'https://twitter.com/intent/tweet?text=My+twitter+title&url=https%3A%2F%2Fmysite.com',
            ],
            'vkontakte button without text results in the default text' => [
                'vkontakte',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://vk.com/share.php?url=https%3A%2F%2Fmysite.com&title=Default+share+text',
            ],
            'vkontakte button with text results in the provided text' => [
                'vkontakte',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My twitter title',
                ],
                'https://vk.com/share.php?url=https%3A%2F%2Fmysite.com&title=My+twitter+title',
            ],
            'whatsapp button without text results in the default text' => [
                'whatsapp',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://wa.me/?text=https%3A%2F%2Fmysite.com%20Default+share+text',
            ],
            'whatsapp button with text results in the provided text' => [
                'whatsapp',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My whatsapp title',
                ],
                'https://wa.me/?text=https%3A%2F%2Fmysite.com%20My+whatsapp+title',
            ],
            'xing button with text results in without text' => [
                'xing',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My xing title',
                ],
                'https://www.xing.com/spi/shares/new?url=https%3A%2F%2Fmysite.com',
            ],
        ];
    }

    /** @test */
    public function it_can_generate_a_hashed_url_for_copylink(): void
    {
        config()->set('share-buttons.buttons.copylink.extra.hash', true);

        $generatedUrl = $this->presenter->generateUrl('copylink', []);

        $this->assertSame('#', $generatedUrl);
    }

    /** @test */
    public function it_can_generate_a_url_with_infromation_from_defaults(): void
    {
        $expectedUrl = 'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Default+share+text';

        $generatedUrl = $this->presenter->generateUrl('facebook', [
            'url' => 'https://mysite.com',
            'text' => '',
        ]);

        $this->assertSame($expectedUrl, $generatedUrl);
    }

    /** @test */
    public function it_can_generate_a_url_with_information_from_call_options(): void
    {
        $expectedUrl = 'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title';

        $generatedUrl = $this->presenter->generateUrl('facebook', [
            'url' => 'https://mysite.com',
            'text' => 'Title',
        ]);

        $this->assertSame($expectedUrl, $generatedUrl);
    }

    /** @test */
    public function it_can_generate_a_url_with_summary_for_linkedin(): void
    {
        $expectedUrl = 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=Default+share+text&summary=Share+text';

        $generatedUrl = $this->presenter->generateUrl('linkedin', [
            'url' => 'https://mysite.com',
            'text' => '',
            'summary' => 'Share text',
        ]);

        $this->assertSame($expectedUrl, $generatedUrl);;
    }
}