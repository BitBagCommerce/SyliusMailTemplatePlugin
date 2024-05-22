<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\MailPreviewData;

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
