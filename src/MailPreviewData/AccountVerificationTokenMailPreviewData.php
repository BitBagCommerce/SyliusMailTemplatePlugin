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
use Sylius\Component\Locale\Model\LocaleInterface;

final class AccountVerificationTokenMailPreviewData implements MailPreviewDataInterface
{
    public const INDEX = 'account_verification_token';

    private ChannelExampleFactory $channelExampleFactory;

    private PreviewDataFactoryInterface $customerPreviewDataFactory;

    public function __construct(ChannelExampleFactory $channelExampleFactory, PreviewDataFactoryInterface $customerPreviewDataFactory)
    {
        $this->channelExampleFactory = $channelExampleFactory;
        $this->customerPreviewDataFactory = $customerPreviewDataFactory;
    }

    public function getData(): array
    {
        $customer = $this->customerPreviewDataFactory->create();
        $channel = $this->channelExampleFactory->create();
        /** @var LocaleInterface $defaultLocale */
        $defaultLocale = $channel->getDefaultLocale();
        $localeCode = $defaultLocale->getCode();

        return [
            MailPreviewDataInterface::USER_KEY => $customer,
            MailPreviewDataInterface::CHANNEL_KEY => $channel,
            MailPreviewDataInterface::LOCALE_CODE_KEY => $localeCode,
        ];
    }

    public static function getIndex(): string
    {
        return self::INDEX;
    }
}
