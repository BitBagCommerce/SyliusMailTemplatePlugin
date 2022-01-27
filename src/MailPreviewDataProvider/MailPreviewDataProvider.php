<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\MailPreviewDataProvider;

use Webmozart\Assert\Assert;

final class MailPreviewDataProvider implements MailPreviewDataProviderInterface
{
    private iterable $mailPreviewData;

    public function __construct(iterable $mailPreviewData)
    {
        $this->mailPreviewData = $mailPreviewData instanceof \Traversable ? iterator_to_array($mailPreviewData) : $mailPreviewData;
    }

    public function get(string $emailType): ?MailPreviewDataInterface
    {
        if (!isset($this->mailPreviewData[$emailType])) {
            return null;
        }

        $mailPreviewData = $this->mailPreviewData[$emailType];
        Assert::isInstanceOf($mailPreviewData, MailPreviewDataInterface::class);

        return $mailPreviewData;
    }
}