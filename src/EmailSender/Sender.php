<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\EmailSender;

use BitBag\SyliusMailTemplatePlugin\Resolver\TemplateResourceResolver;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class Sender implements SenderInterface
{
    private SenderInterface $decoratedSender;
    private TemplateResourceResolver $templateResolver;

    public function __construct(SenderInterface $decoratedSender, TemplateResourceResolver $templateResolver)
    {
        $this->decoratedSender = $decoratedSender;
        $this->templateResolver = $templateResolver;
    }

    public function send(string $code, array $recipients, array $data = [], array $attachments = [], array $replyTo = []): void
    {
        $template = $this->templateResolver->findOrLog($code);

        $data['template'] = $template;

        $this->decoratedSender->send($code, $recipients, $data, $attachments, $replyTo);
    }
}
