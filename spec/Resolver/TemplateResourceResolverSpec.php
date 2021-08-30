<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusMailTemplatePlugin\Resolver;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslationInterface;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateTranslationRepositoryInterface;
use BitBag\SyliusMailTemplatePlugin\Resolver\TemplateResourceResolver;
use BitBag\SyliusMailTemplatePlugin\Resolver\TemplateResourceResolverInterface;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class TemplateResourceResolverSpec extends ObjectBehavior
{
    function let(
        LocaleContextInterface $localeContext,
        EmailTemplateTranslationRepositoryInterface $emailTemplateTranslationRepository,
        LoggerInterface $logger
    ): void {
        $this->beConstructedWith($localeContext, $emailTemplateTranslationRepository, $logger);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(TemplateResourceResolver::class);
    }

    function it_implements_block_resource_resolver_interface(): void
    {
        $this->shouldHaveType(TemplateResourceResolverInterface::class);
    }

    function it_logs_warning_if_email_template_was_not_found(
        EmailTemplateTranslationRepositoryInterface $emailTemplateTranslationRepository,
        LoggerInterface $logger,
        LocaleContextInterface $localeContext
    ) {
        $localeContext->getLocaleCode()->willReturn('en_US');
        $emailTemplateTranslationRepository->findOneByLocaleCodeAndType('en_US', 'big_boom')->willReturn(null);

        $logger
            ->warning(sprintf(
                'Email template with "%s" code was not found in the database.',
                'big_boom'
            ))
            ->shouldBeCalled();

        $this->findOrLog('big_boom');
    }

    function it_returns_email_template_if_found_in_database(
        EmailTemplateTranslationRepositoryInterface $emailTemplateTranslationRepository,
        EmailTemplateTranslationInterface $emailTemplate,
        LocaleContextInterface $localeContext
    ) {
        $localeContext->getLocaleCode()->willReturn('en_US');
        $emailTemplateTranslationRepository->findOneByLocaleCodeAndType('en_US', 'contact_request')->willReturn($emailTemplate);

        $this->findOrLog('contact_request')->shouldReturn($emailTemplate);
    }
}
