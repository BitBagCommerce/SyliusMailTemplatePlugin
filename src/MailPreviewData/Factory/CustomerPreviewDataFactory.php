<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\MailPreviewData\Factory;

use Faker\Factory;
use Faker\Generator;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class CustomerPreviewDataFactory implements PreviewDataFactoryInterface
{
    private FactoryInterface $customerFactory;

    private Generator $faker;

    public function __construct(FactoryInterface $customerFactory)
    {
        $this->customerFactory = $customerFactory;
        $this->faker = Factory::create();
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
