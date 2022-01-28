<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

namespace spec\BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\MailPreviewData\MailPreviewDataInterface;
use BitBag\SyliusMailTemplatePlugin\Provider\MailPreviewDataProvider;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\InvalidArgumentException;

class MailPreviewDataProviderSpec extends ObjectBehavior
{
    public const FOO = 'foo';

    function let(): void
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MailPreviewDataProvider::class);
    }

    function it_should_throw_exception_if_generic_mail_preview_data_doesnt_exist(): void
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('get', [self::FOO]);
    }

    function it_should_return_generic_mail_preview_data_if_none_mail_preview_data_for_requested_type_exist(
        MailPreviewDataInterface $genericMailPreviewData
    ): void {
        $availableMailPreviewData = [
            MailPreviewDataProvider::GENERIC_PREVIEW_DATA_KEY => $genericMailPreviewData,
        ];
        $this->beConstructedWith($availableMailPreviewData);

        $mailPreviewData = $this->get(self::FOO);

        $mailPreviewData->shouldBe($genericMailPreviewData);
    }

    function it_should_throw_exception_if_matched_mail_preview_data_is_not_implementing_mail_preview_data_interface(): void
    {
        $availableMailPreviewData = [
            self::FOO => new \stdClass(),
        ];

        $this->beConstructedWith($availableMailPreviewData);

        $this->shouldThrow(InvalidArgumentException::class)->during('get', [self::FOO]);
    }

    function it_should_return_mail_preview_data_for_requested_type(
        MailPreviewDataInterface $genericMailPreviewData,
        MailPreviewDataInterface $fooMailPreviewData
    ): void {
        $availableMailPreviewData = [
            MailPreviewDataProvider::GENERIC_PREVIEW_DATA_KEY => $genericMailPreviewData,
            self::FOO => $fooMailPreviewData,
        ];
        $this->beConstructedWith($availableMailPreviewData);

        $this->get(self::FOO)->shouldBe($fooMailPreviewData);
    }
}
