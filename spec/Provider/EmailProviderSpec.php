<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

namespace spec\BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplate;
use BitBag\SyliusMailTemplatePlugin\Provider\EmailProvider;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Mailer\Model\EmailInterface;
use Sylius\Component\Mailer\Provider\EmailProviderInterface;

class EmailProviderSpec extends ObjectBehavior
{
    public const FOO_TYPE = 'foo';

    function let(EmailProviderInterface $emailProvider, EmailTemplateRepositoryInterface $emailTemplateRepository): void
    {
        $this->beConstructedWith($emailProvider, $emailTemplateRepository);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(EmailProvider::class);
    }

    function it_should_change_email_template_if_custom_email_template_found(
        EmailProviderInterface $emailProvider,
        EmailTemplateRepositoryInterface $emailTemplateRepository,
        EmailInterface $email
    ): void {
        $email->setTemplate(EmailProvider::CUSTOM_EMAIL_TEMPLATE_PATH)->shouldBeCalled();
        $emailProvider->getEmail(self::FOO_TYPE)->willReturn($email);
        $emailTemplateRepository->findOneByType(self::FOO_TYPE)->willReturn(new EmailTemplate());

        $email = $this->getEmail(self::FOO_TYPE);
        $email->shouldBe($email);
    }

    function it_should_not_change_email_template_if_custom_email_template_not_found(
        EmailProviderInterface $emailProvider,
        EmailTemplateRepositoryInterface $emailTemplateRepository,
        EmailInterface $email
    ): void {
        $email->setTemplate(EmailProvider::CUSTOM_EMAIL_TEMPLATE_PATH)->shouldNotBeCalled();
        $emailProvider->getEmail(self::FOO_TYPE)->willReturn($email);
        $emailTemplateRepository->findOneByType(self::FOO_TYPE)->willReturn(null);

        $email = $this->getEmail(self::FOO_TYPE);
        $email->shouldBe($email);
    }
}
