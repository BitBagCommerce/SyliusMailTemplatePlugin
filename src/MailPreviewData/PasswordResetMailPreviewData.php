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
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Model\LocaleInterface;

final class PasswordResetMailPreviewData implements MailPreviewDataInterface
{
    public const INDEX = 'password_reset';

    private ExampleFactoryInterface $channelExampleFactory;

    private PreviewDataFactoryInterface $customerPreviewDataFactory;

    public function __construct(ExampleFactoryInterface $channelExampleFactory, PreviewDataFactoryInterface $customerPreviewDataFactory)
    {
        $this->channelExampleFactory = $channelExampleFactory;
        $this->customerPreviewDataFactory = $customerPreviewDataFactory;
    }

    public function getData(): array
    {
        $user = $this->customerPreviewDataFactory->create();
        /** @var ChannelInterface $channel */
        $channel = $this->channelExampleFactory->create();
        /** @var LocaleInterface $defaultLocale */
        $defaultLocale = $channel->getDefaultLocale();
        $localeCode = $defaultLocale->getCode();

        return [
            MailPreviewDataInterface::USER_KEY => $user,
            MailPreviewDataInterface::CHANNEL_KEY => $channel,
            MailPreviewDataInterface::LOCALE_CODE_KEY => $localeCode,
        ];
    }

    public static function getIndex(): string
    {
        return self::INDEX;
    }
}
