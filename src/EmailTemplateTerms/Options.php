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
