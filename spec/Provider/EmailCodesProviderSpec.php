<?php

declare(strict_types=1);

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

namespace spec\BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\Provider\EmailCodesProvider;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\CoreBundle\Mailer\Emails;

class EmailCodesProviderSpec extends ObjectBehavior
{
    public const EXAMPLE_EMAILS_CONFIGURATION = [
        Emails::CONTACT_REQUEST => [],
        Emails::ORDER_CONFIRMATION => [],
        Emails::SHIPMENT_CONFIRMATION => [],
    ];

    public const CONTACT_REQUEST_LABEL = 'Contact Request';

    public const ORDER_CONFIRMATION_LABEL = 'Order Confirmation';

    public const SHIPMENT_CONFIRMATION_LABEL = 'Shipment Confirmation';

    function let(EmailTemplateRepositoryInterface $emailTemplateRepository): void
    {
        $this->beConstructedWith(self::EXAMPLE_EMAILS_CONFIGURATION, $emailTemplateRepository);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(EmailCodesProvider::class);
    }

    function it_should_return_email_codes_with_labels(): void
    {
        $emailCodesWithLabels = $this->provideWithLabels();

        $emailCodesWithLabels->shouldBeArray();
        $emailCodesWithLabels->shouldHaveKeyWithValue(self::CONTACT_REQUEST_LABEL, Emails::CONTACT_REQUEST);
        $emailCodesWithLabels->shouldHaveKeyWithValue(self::ORDER_CONFIRMATION_LABEL, Emails::ORDER_CONFIRMATION);
        $emailCodesWithLabels->shouldHaveKeyWithValue(self::SHIPMENT_CONFIRMATION_LABEL, Emails::SHIPMENT_CONFIRMATION);
    }

    function it_should_return_email_template_types(EmailTemplateRepositoryInterface $emailTemplateRepository): void
    {
        $emailTemplateRepository->getAllTypes()->willReturn([]);

        $emailCodesWithLabels = $this->provideWithLabelsNotUsedTypes();

        $emailCodesWithLabels->shouldBeArray();
        $emailCodesWithLabels->shouldHaveKeyWithValue(self::CONTACT_REQUEST_LABEL, Emails::CONTACT_REQUEST);
        $emailCodesWithLabels->shouldHaveKeyWithValue(self::ORDER_CONFIRMATION_LABEL, Emails::ORDER_CONFIRMATION);
        $emailCodesWithLabels->shouldHaveKeyWithValue(self::SHIPMENT_CONFIRMATION_LABEL, Emails::SHIPMENT_CONFIRMATION);
    }

    function it_should_return_not_email_template_types(EmailTemplateRepositoryInterface $emailTemplateRepository): void
    {
        $emailTemplateRepository->getAllTypes()->willReturn([
            [
                'type' => 'contact_request',
            ],
            [
                'type' => 'order_confirmation',
            ],
            [
                'type' => 'shipment_confirmation',
            ],
        ]);

        $emailCodesWithLabels = $this->provideWithLabelsNotUsedTypes();

        $emailCodesWithLabels->shouldBeArray();
        $emailCodesWithLabels->shouldBeEqualTo([]);
    }
}
