<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
