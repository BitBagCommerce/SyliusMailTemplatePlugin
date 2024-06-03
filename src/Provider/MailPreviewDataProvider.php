<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\MailPreviewData\MailPreviewDataInterface;
use Webmozart\Assert\Assert;

final class MailPreviewDataProvider implements MailPreviewDataProviderInterface
{
    public const GENERIC_PREVIEW_DATA_KEY = 'generic';

    private array $mailPreviewData;

    public function __construct(iterable $mailPreviewData)
    {
        $this->mailPreviewData = $mailPreviewData instanceof \Traversable ? iterator_to_array($mailPreviewData) : $mailPreviewData;
    }

    public function get(?string $emailType): MailPreviewDataInterface
    {
        Assert::notNull($emailType);
        Assert::keyExists($this->mailPreviewData, self::GENERIC_PREVIEW_DATA_KEY);

        if (!isset($this->mailPreviewData[$emailType])) {
            return $this->mailPreviewData[self::GENERIC_PREVIEW_DATA_KEY];
        }

        $mailPreviewData = $this->mailPreviewData[$emailType];
        Assert::isInstanceOf($mailPreviewData, MailPreviewDataInterface::class);

        return $mailPreviewData;
    }
}
