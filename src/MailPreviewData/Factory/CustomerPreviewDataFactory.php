<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory;

use Faker\Generator;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class CustomerPreviewDataFactory implements PreviewDataFactoryInterface
{
    private FactoryInterface $customerFactory;

    private Generator $faker;

    public function __construct(FactoryInterface $customerFactory, Generator $faker)
    {
        $this->customerFactory = $customerFactory;
        $this->faker = $faker;
    }

    public function create(): CustomerInterface
    {
        /** @var CustomerInterface $customer */
        $customer = $this->customerFactory->createNew();
        $customer->setFirstName($this->faker->firstName);
        $customer->setLastName($this->faker->lastName);
        $customerEmail = $this->faker->email;
        $customer->setEmail($customerEmail);
        $customer->setEmailCanonical($customerEmail);
        $customer->setBirthday($this->faker->dateTimeBetween('-100 years', '-18 years'));
        $customer->setCreatedAt($this->faker->dateTimeBetween('-100 years', '-18 years'));
        $customer->setUpdatedAt($this->faker->dateTimeBetween('-100 years', '-18 years'));
        $customer->setPhoneNumber($this->faker->phoneNumber);
        $customer->setSubscribedToNewsletter(false);

        return $customer;
    }
}
