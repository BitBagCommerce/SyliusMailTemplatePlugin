<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\MailPreviewDataProvider;

use Sylius\Bundle\CoreBundle\Fixture\Factory\OrderExampleFactory;
use Sylius\Bundle\CoreBundle\Mailer\Emails;

final class ShipmentConfirmationMailPreviewData implements MailPreviewDataInterface
{
    private OrderExampleFactory $orderExampleFactory;

    public function __construct(OrderExampleFactory $orderExampleFactory)
    {
        $this->orderExampleFactory = $orderExampleFactory;
    }

    public function getData(): array
    {
        $order = $this->orderExampleFactory->create();
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
