<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Repository;

use ApiTestCase\JsonApiTestCase;
use BitBag\SyliusMailTemplatePlugin\Provider\EmailCodesProviderInterface;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateRepositoryInterface;
use PHPUnit\Framework\Assert;

final class EmailTemplateTest extends JsonApiTestCase
{
    private EmailTemplateRepositoryInterface $emailTemplateRepository;

    private EmailCodesProviderInterface $emailCodesProvider;

    public function __construct(
        ?string $name = null,
        array $data = [],
        string $dataName = '',
    ) {
        parent::__construct($name, $data, $dataName);

        $this->dataFixturesPath = __DIR__ . '/DataFixtures/ORM';
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $container = $this->getContainer();

        $this->emailTemplateRepository = $container->get('bitbag_sylius_mail_template_plugin.custom_repository.email_template');
        $this->emailCodesProvider = $container->get('bitbag_sylius_mail_template_plugin.provider.email_codes');

        $this->loadFixturesFromFiles([
             'email_templates.yml',
        ]);
    }

    public function test_return_used_template_email_types(): void
    {
        $emailTemplateTypes = $this->emailTemplateRepository->getAllTypes();

        Assert::assertIsArray($emailTemplateTypes, 'This is not an array.');

        Assert::assertCount(2, $emailTemplateTypes);

        Assert::assertArrayHasKey('type', $emailTemplateTypes[0]);
    }

    public function test_available_choices_by_email_template(): void
    {
        $emailTemplate = $this->emailTemplateRepository->findOneBy([]);

        $choices = $this->emailCodesProvider->getAvailableEmailTemplateTypes($emailTemplate);

        Assert::assertEquals(
            count($choices) - 1,
            count($this->emailCodesProvider->provideWithLabelsNotUsedTypes()),
        );
    }
}
