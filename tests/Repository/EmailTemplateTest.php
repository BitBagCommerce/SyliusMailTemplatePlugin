<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
        string $dataName = ''
    ) {
        parent::__construct($name, $data, $dataName);

        $this->dataFixturesPath = __DIR__ . '/DataFixtures/ORM';
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::$container;

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
            count($this->emailCodesProvider->provideWithLabelsNotUsedTypes())
        );
    }
}
