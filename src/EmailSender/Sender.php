<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\EmailSender;

use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateTranslationRepositoryInterface;
use Sylius\Component\Mailer\Provider\DefaultSettingsProviderInterface;
use Sylius\Component\Mailer\Provider\EmailProviderInterface;
use Sylius\Component\Mailer\Renderer\Adapter\AdapterInterface as RendererAdapterInterface;
use Sylius\Component\Mailer\Sender\Adapter\AdapterInterface as SenderAdapterInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class Sender implements SenderInterface
{
    public const CUSTOM_EMAIL_TEMPLATE_PATH = '@BitBagSyliusMailTemplatePlugin/Admin/Email/customTemplate.html.twig';

    public const TEMPLATE = 'template';

    public const LOCALE_CODE_KEY = 'localeCode';

    private RendererAdapterInterface $rendererAdapter;

    private SenderAdapterInterface $senderAdapter;

    private EmailProviderInterface $provider;

    private DefaultSettingsProviderInterface $defaultSettingsProvider;

    private EmailTemplateTranslationRepositoryInterface $templateTranslationRepository;

    public function __construct(
        RendererAdapterInterface $rendererAdapter,
        SenderAdapterInterface $senderAdapter,
        EmailProviderInterface $provider,
        DefaultSettingsProviderInterface $defaultSettingsProvider,
        EmailTemplateTranslationRepositoryInterface $templateTranslationRepository
    ) {
        $this->senderAdapter = $senderAdapter;
        $this->rendererAdapter = $rendererAdapter;
        $this->provider = $provider;
        $this->defaultSettingsProvider = $defaultSettingsProvider;
        $this->templateTranslationRepository = $templateTranslationRepository;
    }

    public function send(
        string $code,
        array $recipients,
        array $data = [],
        array $attachments = [],
        array $replyTo = []
    ): void
    {
        $email = $this->provider->getEmail($code);

        if (!$email->isEnabled()) {
            return;
        }

        $customTemplate = $this->templateTranslationRepository->findOneByLocaleCodeAndType(
            $data[self::LOCALE_CODE_KEY] ?? '',
            $code
        );

        if (null !== $customTemplate) {
            $email->setTemplate(self::CUSTOM_EMAIL_TEMPLATE_PATH);
            $data[self::TEMPLATE] = $customTemplate;
        }

        $senderAddress = $email->getSenderAddress() ?: $this->defaultSettingsProvider->getSenderAddress();
        $senderName = $email->getSenderName() ?: $this->defaultSettingsProvider->getSenderName();

        $renderedEmail = $this->rendererAdapter->render($email, $data);

        $this->senderAdapter->send(
            $recipients,
            $senderAddress,
            $senderName,
            $renderedEmail,
            $email,
            $data,
            $attachments,
            $replyTo
        );
    }
}
