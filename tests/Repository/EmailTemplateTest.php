<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Repository;

use BitBag\SyliusMailTemplatePlugin\Provider\EmailCodesProviderInterface;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateRepositoryInterface;
use BitBag\SyliusMailTemplatePlugin\Service\EmailTemplateServiceInterface;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EmailTemplateTest extends WebTestCase
{
    /** @var EmailTemplateRepositoryInterface $emailTemplateRepository */
    private $emailTemplateRepository;

    /** @var EmailTemplateServiceInterface $emailTemplateService */
    private $emailTemplateService;

    /** @var EmailCodesProviderInterface */
    private $emailCodesProvider;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->emailTemplateRepository = self::$container->get('bitbag_sylius_mail_template_plugin.custom_repository.email_template');
        $this->emailTemplateService = self::$container->get('bitbag_sylius_mail_template_plugin.service.email_template_service');
        $this->emailCodesProvider = self::$container->get('bitbag_sylius_mail_template_plugin.provider.email_codes');
    }

    public function test_return_used_template_email_types(): void
    {
        $emailTemplateTypes = $this->emailTemplateRepository->getAllTypes();

        Assert::assertIsArray($emailTemplateTypes, 'This is not an array.');

        Assert::assertCount(1, $emailTemplateTypes);

        Assert::assertArrayHasKey('type', $emailTemplateTypes[0]);
    }

    public function test_available_choices_by_email_template(): void
    {
        $emailTemplate = $this->emailTemplateRepository->findOneBy([]);

        Assert:self::assertNotNull($emailTemplate, 'EmailTemplate was not found.');

        $emailTemplateTypes = $this->emailTemplateRepository->getAllTypes();

        Assert::assertIsArray($emailTemplateTypes, 'This is not an array.');

        $choices = $this->emailTemplateService->getAvailableEmailTemplateTypes($emailTemplate);

        Assert::assertEquals(
            count($choices) - 1,
            count($this->emailCodesProvider->provideWithLabelsNotUsedTypes())
        );
    }
}
