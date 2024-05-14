<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusMailTemplatePlugin\EmailSender;

use BitBag\SyliusMailTemplatePlugin\EmailSender\Sender;
use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslation;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateTranslationRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Mailer\Model\EmailInterface;
use Sylius\Component\Mailer\Provider\DefaultSettingsProviderInterface;
use Sylius\Component\Mailer\Provider\EmailProviderInterface;
use Sylius\Component\Mailer\Renderer\Adapter\AdapterInterface as RendererAdapterInterface;
use Sylius\Component\Mailer\Renderer\RenderedEmail;
use Sylius\Component\Mailer\Sender\Adapter\AdapterInterface as SenderAdapterInterface;

final class SenderSpec extends ObjectBehavior
{
    public const FOO = 'foo';

    public const BAR = 'bar';

    public const LOCALE = 'en_US';

    public const EMAIL_TYPE = 'test';

    public const DEFAULT_DATA = [
        'localeCode' => self::LOCALE,
    ];

    function it_is_initializable(
        RendererAdapterInterface $rendererAdapter,
        SenderAdapterInterface $senderAdapter,
        EmailProviderInterface $provider,
        DefaultSettingsProviderInterface $defaultSettingsProvider,
        EmailTemplateTranslationRepositoryInterface $templateTranslationRepository,
    ): void {
        $this->beConstructedWith(
            $rendererAdapter,
            $senderAdapter,
            $provider,
            $defaultSettingsProvider,
            $templateTranslationRepository,
        );
        $this->shouldHaveType(Sender::class);
    }

    function it_should_send_email(
        RendererAdapterInterface $rendererAdapter,
        SenderAdapterInterface $senderAdapter,
        EmailProviderInterface $provider,
        DefaultSettingsProviderInterface $defaultSettingsProvider,
        EmailTemplateTranslationRepositoryInterface $templateTranslationRepository,
        EmailInterface $email,
        RenderedEmail $renderedEmail,
    ): void {
        $this->beConstructedWith(
            $rendererAdapter,
            $senderAdapter,
            $provider,
            $defaultSettingsProvider,
            $templateTranslationRepository,
        );

        $email->isEnabled()->willReturn(true);
        $email->getSenderAddress()->willReturn(self::FOO);
        $email->getSenderName()->willReturn(self::BAR);
        $email->setTemplate(Sender::CUSTOM_EMAIL_TEMPLATE_PATH)->shouldNotBeCalled();

        $provider->getEmail(self::EMAIL_TYPE)->willReturn($email);

        $templateTranslationRepository->findOneByLocaleCodeAndType(self::LOCALE, self::EMAIL_TYPE)->willReturn(null);

        $rendererAdapter->render($email, Argument::type('array'))->willReturn($renderedEmail);

        $senderAdapter->send(
            Argument::type('array'),
            self::FOO,
            self::BAR,
            $renderedEmail,
            $email,
            Argument::type('array'),
            Argument::type('array'),
            Argument::type('array'),
        );

        $this->send(self::EMAIL_TYPE, [], self::DEFAULT_DATA, [], []);
    }

    function it_should_set_custom_email_template_if_found(
        RendererAdapterInterface $rendererAdapter,
        SenderAdapterInterface $senderAdapter,
        EmailProviderInterface $provider,
        DefaultSettingsProviderInterface $defaultSettingsProvider,
        EmailTemplateTranslationRepositoryInterface $templateTranslationRepository,
        EmailInterface $email,
        RenderedEmail $renderedEmail,
    ): void {
        $this->beConstructedWith(
            $rendererAdapter,
            $senderAdapter,
            $provider,
            $defaultSettingsProvider,
            $templateTranslationRepository,
        );

        $email->isEnabled()->willReturn(true);
        $email->getSenderAddress()->willReturn(self::FOO);
        $email->getSenderName()->willReturn(self::BAR);
        $email->setTemplate(Sender::CUSTOM_EMAIL_TEMPLATE_PATH)->shouldBeCalled();

        $provider->getEmail(self::EMAIL_TYPE)->willReturn($email);

        $emailTemplateTranslation = new EmailTemplateTranslation();
        $templateTranslationRepository->findOneByLocaleCodeAndType(
            self::LOCALE,
            self::EMAIL_TYPE,
        )->willReturn($emailTemplateTranslation);

        $rendererAdapter->render($email, Argument::type('array'))->willReturn($renderedEmail);

        $senderAdapter->send(
            Argument::type('array'),
            self::FOO,
            self::BAR,
            $renderedEmail,
            $email,
            Argument::containing($emailTemplateTranslation),
            Argument::type('array'),
            Argument::type('array'),
        );

        $this->send(self::EMAIL_TYPE, [], self::DEFAULT_DATA, [], []);
    }
}
