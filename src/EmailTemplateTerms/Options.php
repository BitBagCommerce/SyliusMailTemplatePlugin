<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\EmailTemplateTerms;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateInterface;

final class Options
{
    public const PAYMENT_LINK = 'bitbag_sylius_mail_template_plugin.ui.paymentlink';

    public const PAYMENT_LINK_ABANDONED = 'bitbag_sylius_mail_template_plugin.ui.paymentlinkAbandoned';

    public static function getAvailableEmailTemplate(): array
    {
        return [
            self::PAYMENT_LINK => EmailTemplateInterface::PAYMENT_LINK,
            self::PAYMENT_LINK_ABANDONED => EmailTemplateInterface::PAYMENT_LINK_ABANDONED,
        ];
    }
}
