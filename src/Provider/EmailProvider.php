<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateRepositoryInterface;
use Sylius\Component\Mailer\Model\EmailInterface;
use Sylius\Component\Mailer\Provider\EmailProviderInterface;

final class EmailProvider implements EmailProviderInterface
{
    public const CUSTOM_EMAIL_TEMPLATE_PATH = '@BitBagSyliusMailTemplatePlugin/Admin/Email/customTemplate.html.twig';

    private EmailProviderInterface $decoratedEmailProvider;

    private EmailTemplateRepositoryInterface $emailTemplateRepository;

    public function __construct(
        EmailProviderInterface $decoratedEmailProvider,
        EmailTemplateRepositoryInterface $emailTemplateRepository
    ) {
        $this->decoratedEmailProvider = $decoratedEmailProvider;
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    public function getEmail(string $code): EmailInterface
    {
        $emailTemplate = $this->emailTemplateRepository->findOneByType($code);
        $email = $this->decoratedEmailProvider->getEmail($code);

        if (null !== $emailTemplate) {
            $email->setTemplate(self::CUSTOM_EMAIL_TEMPLATE_PATH);
        }

        return $email;
    }
}
