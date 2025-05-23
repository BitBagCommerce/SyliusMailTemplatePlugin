<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Entity;

use Sylius\Resource\Model\ResourceInterface;
use Sylius\Resource\Model\TranslatableInterface;

interface EmailTemplateInterface extends ResourceInterface, TranslatableInterface
{
    public const ORDER_CONFIRMATION = 'order_confirmation';

    public const USER_REGISTRATION = 'user_registration';

    public const SHIPMENT_CONFIRMATION = 'shipment_confirmation';

    public const RESET_PASSWORD_TOKEN = 'reset_password_token';

    public const VERIFICATION_TOKEN = 'verification_token';

    public const CONTACT_REQUEST = 'contact_request';

    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getSubject(): ?string;

    public function setSubject(?string $subject): void;

    public function getContent(): ?string;

    public function setContent(?string $content): void;

    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getStyleCss(): ?string;

    public function setStyleCss(?string $styleCss): void;
}
