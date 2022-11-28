<?php

namespace Kudashevs\ShareButtons\Tests\UrlProviders;

use Kudashevs\ShareButtons\Tests\ExtendedTestCase;
use Kudashevs\ShareButtons\UrlProviders\TemplateUrlProvider;

class TemplateUrlProviderTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->provider = new TemplateUrlProvider();
    }

    /** @test */
    public function it_can_generate_an_empty_url_when_wrong_name()
    {
        $result = $this->provider->generateUrl('wrong', []);

        $this->assertSame('', $result);
    }

    /**
     * @test
     * @dataProvider provideDifferentShareProviderValues
     */
    public function it_can_generate_a_url(string $name, array $arguments, string $expected)
    {
        $result = $this->provider->generateUrl($name, $arguments);

        $this->assertSame($expected, $result);
    }

    public function provideDifferentShareProviderValues()
    {
        return [
            'copylink provider' => [
                'copylink',
                [
                    'url' => 'https://mysite.com',
                ],
                'https%3A%2F%2Fmysite.com',
            ],
            'evernote provider without text results in the default text' => [
                'evernote',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://www.evernote.com/clip.action?url=https%3A%2F%2Fmysite.com&t=Default+share+text',
            ],
            'evernote provider with text results in the provided text' => [
                'evernote',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My evernote title',
                ],
                'https://www.evernote.com/clip.action?url=https%3A%2F%2Fmysite.com&t=My+evernote+title',
            ],
            'facebook provider without text results in the default text' => [
                'facebook',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Default+share+text',
            ],
            'facebook provider with text results in the provided text' => [
                'facebook',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My facebook title',
                ],
                'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=My+facebook+title',
            ],
            'hackernews provider without text results in the default text' => [
                'hackernews',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://news.ycombinator.com/submitlink?t=Default+share+text&u=https%3A%2F%2Fmysite.com',
            ],
            'hackernews provider with text results in the provided text' => [
                'hackernews',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My hacker news title',
                ],
                'https://news.ycombinator.com/submitlink?t=My+hacker+news+title&u=https%3A%2F%2Fmysite.com',
            ],
            'linkedin provider without text results in the default text' => [
                'linkedin',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=Default+share+text&summary=',
            ],
            'linkedin provider with text results in the provided text' => [
                'linkedin',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My linkedin title',
                ],
                'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=My+linkedin+title&summary=',
            ],
            'linkedin provider with text and summary results in the provided text and summary' => [
                'linkedin',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My linkedin title',
                    'summary' => 'Text summary',
                ],
                'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=My+linkedin+title&summary=Text+summary',
            ],
            'mailto provider without text results in the default text' => [
                'mailto',
                [
                    'url' => 'https://mysite.com',
                ],
                'mailto:?subject=Default+share+text&body=https%3A%2F%2Fmysite.com',
            ],
            'mailto provider with text results in the provided text' => [
                'mailto',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My share by mail title',
                ],
                'mailto:?subject=My+share+by+mail+title&body=https%3A%2F%2Fmysite.com',
            ],
            'pinterest provider with text results in without text' => [
                'pinterest',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My pinterest title',
                ],
                'https://pinterest.com/pin/create/button/?url=https%3A%2F%2Fmysite.com',
            ],
            'pocket provider without text results in the default text' => [
                'pocket',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://getpocket.com/edit?url=https%3A%2F%2Fmysite.com&title=Default+share+text',
            ],
            'pocket provider with text results in the provided text' => [
                'pocket',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My pocket title',
                ],
                'https://getpocket.com/edit?url=https%3A%2F%2Fmysite.com&title=My+pocket+title',
            ],
            'reddit provider without text results in the default text' => [
                'reddit',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://www.reddit.com/submit?title=Default+share+text&url=https%3A%2F%2Fmysite.com',
            ],
            'reddit provider with text results in the provided text' => [
                'reddit',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My reddit title',
                ],
                'https://www.reddit.com/submit?title=My+reddit+title&url=https%3A%2F%2Fmysite.com',
            ],
            'skype provider without text results in the default text' => [
                'skype',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://web.skype.com/share?url=https%3A%2F%2Fmysite.com&text=Default+share+text&source=button',
            ],
            'skype provider with text results in the provided text' => [
                'skype',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My skype title',
                ],
                'https://web.skype.com/share?url=https%3A%2F%2Fmysite.com&text=My+skype+title&source=button',
            ],
            'telegram provider without text results in the default text' => [
                'telegram',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=Default+share+text',
            ],
            'telegram provider with text results in the provided text' => [
                'telegram',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My telegram title',
                ],
                'https://telegram.me/share/url?url=https%3A%2F%2Fmysite.com&text=My+telegram+title',
            ],
            'twitter provider without text results in the default text' => [
                'twitter',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://twitter.com/intent/tweet?text=Default+share+text&url=https%3A%2F%2Fmysite.com',
            ],
            'twitter provider with text results in the provided text' => [
                'twitter',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My twitter title',
                ],
                'https://twitter.com/intent/tweet?text=My+twitter+title&url=https%3A%2F%2Fmysite.com',
            ],
            'vkontakte provider without text results in the default text' => [
                'vkontakte',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://vk.com/share.php?url=https%3A%2F%2Fmysite.com&title=Default+share+text',
            ],
            'vkontakte provider with text results in the provided text' => [
                'vkontakte',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My twitter title',
                ],
                'https://vk.com/share.php?url=https%3A%2F%2Fmysite.com&title=My+twitter+title',
            ],
            'whatsapp provider without text results in the default text' => [
                'whatsapp',
                [
                    'url' => 'https://mysite.com',
                ],
                'https://wa.me/?text=https%3A%2F%2Fmysite.com%20Default+share+text',
            ],
            'whatsapp provider with text results in the provided text' => [
                'whatsapp',
                [
                    'url' => 'https://mysite.com',
                    'text' => 'My whatsapp title',
                ],
                'https://wa.me/?text=https%3A%2F%2Fmysite.com%20My+whatsapp+title',
            ],
            'xing provider with text results in without text' => [
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
    public function it_can_generate_a_hashed_url_for_copylink()
    {
        config()->set('share-buttons.providers.copylink.extra.hash', true);

        $instance = new TemplateUrlProvider();
        $result = $instance->generateUrl('copylink', []);

        $this->assertSame('#', $result);
    }

    /** @test */
    public function it_can_generate_a_url_with_summary_for_linkedin()
    {
        $expected = 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fmysite.com&title=Default+share+text&summary=Share+text';

        $result = $this->provider->generateUrl('linkedin', [
            'url' => 'https://mysite.com',
            'text' => '',
            'summary' => 'Share text',
        ]);

        $this->assertSame($expected, $result);;
    }

    /** @test */
    public function it_can_generate_a_url_with_infromation_from_defaults()
    {
        $expected = 'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Default+share+text';

        $result = $this->provider->generateUrl('facebook', [
            'url' => 'https://mysite.com',
            'text' => '',
        ]);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_url_with_information_from_call_options()
    {
        $expected = 'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title';

        $result = $this->provider->generateUrl('facebook', [
            'url' => 'https://mysite.com',
            'text' => 'Title',
        ]);

        $this->assertSame($expected, $result);
    }
}
