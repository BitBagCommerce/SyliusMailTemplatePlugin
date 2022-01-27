<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\MailPreviewData;

use Sylius\Bundle\CoreBundle\Fixture\Factory\OrderExampleFactory;
use Sylius\Bundle\CoreBundle\Mailer\Emails;

final class OrderConfirmationResentMailPreviewData implements MailPreviewDataInterface
{
    private MailPreviewDataInterface $orderConfirmationMailPreviewData;

    public function __construct(MailPreviewDataInterface $orderConfirmationMailPreviewData)
    {
        $this->orderConfirmationMailPreviewData = $orderConfirmationMailPreviewData;
    }

    public function getData(): array
    {
        return $this->orderConfirmationMailPreviewData->getData();
    }

    public static function getIndex(): string
    {
        return Emails::ORDER_CONFIRMATION_RESENT;
    }
}
