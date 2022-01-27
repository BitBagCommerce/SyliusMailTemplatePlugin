<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

namespace spec\BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\Provider\EmailCodesProvider;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\CoreBundle\Mailer\Emails;

class EmailCodesProviderSpec extends ObjectBehavior
{
    private const EXAMPLE_EMAILS_CONFIGURATION = [
        Emails::CONTACT_REQUEST => [],
        Emails::ORDER_CONFIRMATION => [],
        Emails::SHIPMENT_CONFIRMATION => [],
    ];

    function let(): void
    {
        $this->beConstructedWith(self::EXAMPLE_EMAILS_CONFIGURATION);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(EmailCodesProvider::class);
    }

    function it_should_return_email_codes_with_labels(): void
    {
        $emailCodesWithLabels = $this->provideWithLabels();

        $emailCodesWithLabels->shouldBeArray();
        $emailCodesWithLabels->shouldHaveKeyWithValue($this->getLabel(Emails::CONTACT_REQUEST), Emails::CONTACT_REQUEST);
        $emailCodesWithLabels->shouldHaveKeyWithValue($this->getLabel(Emails::ORDER_CONFIRMATION), Emails::ORDER_CONFIRMATION);
        $emailCodesWithLabels->shouldHaveKeyWithValue($this->getLabel(Emails::SHIPMENT_CONFIRMATION), Emails::SHIPMENT_CONFIRMATION);
    }

    private function getLabel(string $emailCode): string
    {
        return sprintf('%s.%s', EmailCodesProvider::LABEL_TRANSLATION_PREFIX, $emailCode);
    }
}
