<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\MailPreviewData;

interface MailPreviewDataInterface
{
    public const CUSTOMER_KEY = 'customer';

    public const ORDER_KEY = 'order';

    public const DATA_KEY = 'data';

    public const USER_KEY = 'user';

    public const CHANNEL_KEY = 'channel';

    public const LOCALE_CODE_KEY = 'localeCode';

    public function getData(): array;

    public static function getIndex(): string;
}
