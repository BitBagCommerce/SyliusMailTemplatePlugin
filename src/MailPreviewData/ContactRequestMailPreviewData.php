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
