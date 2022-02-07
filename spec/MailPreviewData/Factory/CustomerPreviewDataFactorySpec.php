<?php

declare(strict_types=1);

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

namespace spec\BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory;

use BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory\CustomerPreviewDataFactory;
use BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory\PreviewDataFactoryInterface;
use Faker\Generator;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\Customer;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class CustomerPreviewDataFactorySpec extends ObjectBehavior
{
    function let(FactoryInterface $factory, Generator $faker)
    {
        $this->beConstructedWith($factory, $faker);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerPreviewDataFactory::class);
        $this->shouldBeAnInstanceOf(PreviewDataFactoryInterface::class);
    }

    function it_should_return_customer_instance(FactoryInterface $factory): void
    {
        $factory->createNew()->willReturn(new Customer());

        $this->create()->shouldBeAnInstanceOf(CustomerInterface::class);
    }
}
