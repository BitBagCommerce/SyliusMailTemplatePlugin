<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusMailTemplatePlugin\Entity;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplate;
use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Resource\Model\ResourceInterface;

final class EmailTemplateSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(EmailTemplate::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_implements_block_interface(): void
    {
        $this->shouldHaveType(EmailTemplateInterface::class);
    }
}
