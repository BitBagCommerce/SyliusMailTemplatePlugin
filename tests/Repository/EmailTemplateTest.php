<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Repository;

use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EmailTemplateTest extends WebTestCase
{
    private $emailTemplateRepository;

    protected function setUp(): void
    {
        $this->emailTemplateRepository = self::$container->get('bitbag_sylius_mail_template_plugin.custom_repository.email_template');
    }

    public function test_return_used_template_email_types(): void
    {
        $emailTemplateTypes = $this->emailTemplateRepository->getAllTypes();

        Assert::assertIsArray($emailTemplateTypes, 'This is not an array.');

        Assert::assertCount( 1, $emailTemplateTypes);

        Assert::assertArrayHasKey('type', $emailTemplateTypes[0]);
    }
}
