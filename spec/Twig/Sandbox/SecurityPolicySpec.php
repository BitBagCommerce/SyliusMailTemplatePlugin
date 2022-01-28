<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusMailTemplatePlugin\Twig\Sandbox;

use BitBag\SyliusMailTemplatePlugin\Twig\Sandbox\SecurityPolicy;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Twig\Sandbox\SecurityPolicyInterface;

class SecurityPolicySpec extends ObjectBehavior
{
    public const STD_CLASS_NAME = 'stdClass';

    public const EXAMPLE_METHOD = 'exampleMethod';

    public const EXAMPLE_PROPERTY = 'exampleProperty';

    function it_is_initializable(SecurityPolicyInterface $securityPolicy): void
    {
        $this->beConstructedWith($securityPolicy, [], []);

        $this->shouldHaveType(SecurityPolicy::class);
    }

    function it_should_call_decorated_class_on_check_security(SecurityPolicyInterface $securityPolicy): void
    {
        $securityPolicy->checkSecurity([], [], [])->shouldBeCalled();

        $this->beConstructedWith($securityPolicy, [], []);
        $this->checkSecurity([], [], []);
    }

    function it_should_not_call_decorated_object_on_check_method_if_allowed_methods_contains_passed_object_type_with_method_wildcard(
        SecurityPolicyInterface $securityPolicy
    ): void {
        $allowedMethods = [
            self::STD_CLASS_NAME => '*',
        ];
        $securityPolicy->checkMethodAllowed(Argument::type('object'), self::EXAMPLE_METHOD)->shouldNotBeCalled();

        $this->beConstructedWith($securityPolicy, $allowedMethods, []);
        $this->checkMethodAllowed(new \stdClass(), self::EXAMPLE_METHOD);
    }

    function it_should_not_call_decorated_object_on_check_method_if_allowed_methods_contains__class_wildcard_with_matching_method(
        SecurityPolicyInterface $securityPolicy
    ): void {
        $allowedMethods = [
            '*' => [
                self::EXAMPLE_METHOD
            ],
        ];
        $securityPolicy->checkMethodAllowed(Argument::type('object'), self::EXAMPLE_METHOD)->shouldNotBeCalled();

        $this->beConstructedWith($securityPolicy, $allowedMethods, []);
        $this->checkMethodAllowed(new \stdClass(), self::EXAMPLE_METHOD);
    }

    function it_should_not_call_decorated_object_on_check_method_if_allowed_methods_contains_wildcard_class_with_wildcard_method(
        SecurityPolicyInterface $securityPolicy
    ): void {
        $allowedMethods = [
            '*' => '*',
        ];
        $securityPolicy->checkMethodAllowed(Argument::type('object'), self::EXAMPLE_METHOD)->shouldNotBeCalled();

        $this->beConstructedWith($securityPolicy, $allowedMethods, []);
        $this->checkMethodAllowed(new \stdClass(), self::EXAMPLE_METHOD);
    }

    function it_should_call_decorated_object_method_on_check_method_if_passed_object_or_method_doesnt_meet_requirements(
        SecurityPolicyInterface $securityPolicy
    ): void {
        $securityPolicy->checkMethodAllowed(Argument::type('object'), self::EXAMPLE_METHOD)->shouldBeCalled();

        $this->beConstructedWith($securityPolicy, [], []);
        $this->checkMethodAllowed(new \stdClass(), self::EXAMPLE_METHOD);
    }

    function it_should_call_decorated_object_method_on_check_property(SecurityPolicyInterface $securityPolicy): void
    {
        $securityPolicy->checkPropertyAllowed(Argument::type('object'), self::EXAMPLE_PROPERTY)->shouldBeCalled();

        $this->beConstructedWith($securityPolicy, [], []);
        $this->checkPropertyAllowed(new \stdClass(), self::EXAMPLE_PROPERTY);
    }
}
