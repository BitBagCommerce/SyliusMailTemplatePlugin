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
    public const ORDER_CONFIRMATION = 'bitbag_sylius_mail_template_plugin.ui.orderConfirmation';

    public const USER_REGISTRATION = 'bitbag_sylius_mail_template_plugin.ui.userRegistration';

    public const SHIPMENT_CONFIRMATION = 'bitbag_sylius_mail_template_plugin.ui.shipmentConfirmation';

    public const RESET_PASSWORD_TOKEN = 'bitbag_sylius_mail_template_plugin.ui.passwordResetToken';

    public const VERIFICATION_TOKEN = 'bitbag_sylius_mail_template_plugin.ui.verificationToken';

    public const CONTACT_REQUEST = 'bitbag_sylius_mail_template_plugin.ui.contactRequest';

    public static function getAvailableEmailTemplate(): array
    {
        return [
            self::ORDER_CONFIRMATION => EmailTemplateInterface::ORDER_CONFIRMATION,
            self::USER_REGISTRATION => EmailTemplateInterface::USER_REGISTRATION,
            self::SHIPMENT_CONFIRMATION => EmailTemplateInterface::SHIPMENT_CONFIRMATION,
            self::RESET_PASSWORD_TOKEN => EmailTemplateInterface::RESET_PASSWORD_TOKEN,
            self::VERIFICATION_TOKEN => EmailTemplateInterface::VERIFICATION_TOKEN,
            self::CONTACT_REQUEST => EmailTemplateInterface::CONTACT_REQUEST,
        ];
    }
}
