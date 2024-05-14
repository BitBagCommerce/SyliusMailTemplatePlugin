<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;

class EmailTemplateTranslation extends AbstractTranslation implements EmailTemplateTranslationInterface
{
    protected ?int $id;

    protected ?string $name;

    protected ?string $subject;

    protected ?string $content;

    protected ?EmailTemplate $emailTemplate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): void
    {
        $this->subject = $subject;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getEmailTemplate(): ?EmailTemplate
    {
        return $this->emailTemplate;
    }

    public function setEmailTemplate(?EmailTemplate $emailTemplate): void
    {
        $this->emailTemplate = $emailTemplate;
    }
}
