<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\MailPreviewData;

use BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory\PreviewDataFactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\OrderExampleFactory;
use Sylius\Bundle\CoreBundle\Mailer\Emails;

final class OrderConfirmationMailPreviewData implements MailPreviewDataInterface
{
    private OrderExampleFactory $orderExampleFactory;

    private PreviewDataFactoryInterface $customerPreviewDataFactory;

    public function __construct(OrderExampleFactory $orderExampleFactory, PreviewDataFactoryInterface $customerPreviewDataFactory)
    {
        $this->orderExampleFactory = $orderExampleFactory;
        $this->customerPreviewDataFactory = $customerPreviewDataFactory;
    }

    public function getData(): array
    {
        $customer = $this->customerPreviewDataFactory->create();
        $order = $this->orderExampleFactory->create([
            MailPreviewDataInterface::CUSTOMER_KEY => $customer,
        ]);
        $channel = $order->getChannel();
        $localeCode = $order->getLocaleCode();

        return [
            MailPreviewDataInterface::ORDER_KEY => $order,
            MailPreviewDataInterface::CHANNEL_KEY => $channel,
            MailPreviewDataInterface::LOCALE_CODE_KEY => $localeCode,
        ];
    }

    public static function getIndex(): string
    {
        return Emails::ORDER_CONFIRMATION;
    }
}
