<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\MailPreviewData;

use BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory\PreviewDataFactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ChannelExampleFactory;
use Sylius\Bundle\CoreBundle\Mailer\Emails;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Locale\Model\LocaleInterface;

final class ContactRequestMailPreviewData implements MailPreviewDataInterface
{
    public const EMAIL = 'email';

    public const MESSAGE = 'message';

    public const MESSAGE_FROM_CUSTOMER = '<MESSAGE_FROM_CUSTOMER>';

    private ChannelExampleFactory $channelExampleFactory;

    private PreviewDataFactoryInterface $customerPreviewDataFactory;

    public function __construct(ChannelExampleFactory $channelExampleFactory, PreviewDataFactoryInterface $customerPreviewDataFactory)
    {
        $this->channelExampleFactory = $channelExampleFactory;
        $this->customerPreviewDataFactory = $customerPreviewDataFactory;
    }

    public function getData(): array
    {
        /** @var CustomerInterface $customer */
        $customer = $this->customerPreviewDataFactory->create();
        $channel = $this->channelExampleFactory->create();
        /** @var LocaleInterface $defaultLocale */
        $defaultLocale = $channel->getDefaultLocale();
        $localeCode = $defaultLocale->getCode();

        $data = [
            self::EMAIL => $customer->getEmail(),
            self::MESSAGE => self::MESSAGE_FROM_CUSTOMER,
        ];

        return [
            MailPreviewDataInterface::DATA_KEY => $data,
            MailPreviewDataInterface::CHANNEL_KEY => $channel,
            MailPreviewDataInterface::LOCALE_CODE_KEY => $localeCode,
        ];
    }

    public static function getIndex(): string
    {
        return Emails::CONTACT_REQUEST;
    }
}
