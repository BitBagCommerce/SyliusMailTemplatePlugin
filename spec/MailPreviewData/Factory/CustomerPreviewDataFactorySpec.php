<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory;

use BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory\CustomerPreviewDataFactory;
use BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory\PreviewDataFactoryInterface;
use Faker\Generator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\Customer;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class CustomerPreviewDataFactorySpec extends ObjectBehavior
{
    public const FIRST_NAME = 'John';

    public const LAST_NAME = 'Doe';

    public const EMAIL = 'john@doe.local';

    public const PHONE_NUMBER = '+48 123 456 789';

    function let(FactoryInterface $factory, Generator $faker)
    {
        $this->beConstructedWith($factory, $faker);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerPreviewDataFactory::class);
        $this->shouldBeAnInstanceOf(PreviewDataFactoryInterface::class);
    }

    function it_should_return_customer_instance(FactoryInterface $factory, Generator $faker): void
    {
        $factory->createNew()->willReturn(new Customer());
        $faker->firstName = self::FIRST_NAME;
        $faker->lastName = self::LAST_NAME;
        $faker->email = self::EMAIL;

        $dateTime = new \DateTime();
        $faker->dateTimeBetween(Argument::type('string'), Argument::type('string'))->willReturn($dateTime);
        $faker->phoneNumber = self::PHONE_NUMBER;

        $customer = $this->create();

        $customer->shouldBeAnInstanceOf(CustomerInterface::class);
        $customer->getFirstName()->shouldBe(self::FIRST_NAME);
        $customer->getLastName()->shouldBe(self::LAST_NAME);
        $customer->getEmail()->shouldBe(self::EMAIL);
        $customer->getEmailCanonical()->shouldBe(self::EMAIL);
        $customer->getBirthday()->shouldBe($dateTime);
        $customer->getCreatedAt()->shouldBe($dateTime);
        $customer->getUpdatedAt()->shouldBe($dateTime);
        $customer->getPhoneNumber()->shouldBe(self::PHONE_NUMBER);
    }
}
