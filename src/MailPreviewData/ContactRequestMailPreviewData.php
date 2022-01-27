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

final class ContactRequestMailPreviewData implements MailPreviewDataInterface
{
    public const EMAIL = 'email';

    public const MESSAGE = 'message';

    private OrderExampleFactory $orderExampleFactory;

    public function __construct(OrderExampleFactory $orderExampleFactory)
    {
        $this->orderExampleFactory = $orderExampleFactory;
    }

    public function getData(): array
    {
        $order = $this->orderExampleFactory->create();
        $data = [
            self::EMAIL => $order->getCustomer()->getEmail(),
            self::MESSAGE => '<MESSAGE_FROM_CUSTOMER>',
        ];
        $channel = $order->getChannel();
        $localeCode = $order->getLocaleCode();

        return [
            'data' => $data,
            'channel' => $channel,
            'localeCode' => $localeCode,
        ];
    }

    public static function getIndex(): string
    {
        return Emails::CONTACT_REQUEST;
    }
}
