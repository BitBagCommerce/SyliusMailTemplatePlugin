<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusMailTemplatePlugin\Entity;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslationInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\TranslationInterface;
use Sylius\Resource\Model\ResourceInterface;

final class EmailTemplateTranslationSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_implements_block_translation_interface(): void
    {
        $this->shouldHaveType(EmailTemplateTranslationInterface::class);
        $this->shouldHaveType(TranslationInterface::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->setName('Pablo favorite quote');
        $this->getName()->shouldReturn('Pablo favorite quote');

        $this->setSubject('https://en.wikipedia.org/wiki/Pablo_Escobar');
        $this->getSubject()->shouldReturn('https://en.wikipedia.org/wiki/Pablo_Escobar');

        $this->setContent('Plata o plomo');
        $this->getContent()->shouldReturn('Plata o plomo');
    }
}
