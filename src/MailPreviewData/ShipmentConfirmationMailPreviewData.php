<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\MailPreviewData;

use BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory\PreviewDataFactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\OrderExampleFactory;
use Sylius\Bundle\CoreBundle\Mailer\Emails;

final class ShipmentConfirmationMailPreviewData implements MailPreviewDataInterface
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
        $shipment = $order->getShipments()->first();
        $channel = $order->getChannel();
        $localeCode = $order->getLocaleCode();

        return [
            'shipment' => $shipment,
            'order' => $order,
            'channel' => $channel,
            'localeCode' => $localeCode,
        ];
    }

    public static function getIndex(): string
    {
        return Emails::SHIPMENT_CONFIRMATION;
    }
}
