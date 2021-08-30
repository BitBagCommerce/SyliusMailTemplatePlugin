<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Resolver;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslationInterface;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateTranslationRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class TemplateResourceResolver implements TemplateResourceResolverInterface
{
    private LocaleContextInterface $localeContext;

    private EmailTemplateTranslationRepositoryInterface $templateRepository;

    private LoggerInterface $logger;

    public function __construct(
        LocaleContextInterface $localeContext,
        EmailTemplateTranslationRepositoryInterface $templateRepository,
        LoggerInterface $logger
    ) {
        $this->localeContext = $localeContext;
        $this->templateRepository = $templateRepository;
        $this->logger = $logger;
    }

    public function findOrLog(string $emailCode): ?EmailTemplateTranslationInterface
    {
        $template = $this->templateRepository->findOneByLocaleCodeAndType(
            $this->localeContext->getLocaleCode(),
            $emailCode
        );

        if (false === $template instanceof EmailTemplateTranslationInterface) {
            $this->logger->warning(sprintf(
                'Email template with "%s" code was not found in the database.',
                $emailCode
            ));

            return null;
        }

        return $template;
    }
}
