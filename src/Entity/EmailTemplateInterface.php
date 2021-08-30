<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

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
