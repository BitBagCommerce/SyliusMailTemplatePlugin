<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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
