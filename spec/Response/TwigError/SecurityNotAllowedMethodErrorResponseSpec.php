<?php

declare(strict_types=1);

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

namespace spec\BitBag\SyliusMailTemplatePlugin\Response\TwigError;

use BitBag\SyliusMailTemplatePlugin\Response\TwigError\SecurityNotAllowedMethodErrorResponse;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedMethodError;
use Webmozart\Assert\InvalidArgumentException;

class SecurityNotAllowedMethodErrorResponseSpec extends ObjectBehavior
{
    public const ERROR_MESSAGE_TRANSLATION = 'Method "%s" is not allowed at line %d';

    public const EXPECTED_RESPONSE_MESSAGE = '{"message":"Method \u0022baz\u0022 is not allowed at line 2"}';

    function let(TranslatorInterface $translator)
    {
        $this->beConstructedWith($translator);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(SecurityNotAllowedMethodErrorResponse::class);
    }

    function it_should_return_true_for_supported_error(): void
    {
        $securityNotAllowedMethodError = new SecurityNotAllowedMethodError('foo', 'bar', 'baz');
        $this->supports($securityNotAllowedMethodError)->shouldReturn(true);
    }

    function it_should_return_false_for_unsupported_error(): void
    {
        $this->supports(new SecurityError('foo'))->shouldReturn(false);
    }

    function it_should_throw_exception_if_get_response_got_unsupported_instance_of_error(): void
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('getResponse', [new SecurityError('foo')]);
    }

    function it_should_return_response_with_proper_message(TranslatorInterface $translator): void
    {
        $translator->trans(SecurityNotAllowedMethodErrorResponse::MESSAGE)->willReturn(self::ERROR_MESSAGE_TRANSLATION);
        $error = new SecurityNotAllowedMethodError('foo', 'bar', 'baz', 2);

        $this->beConstructedWith($translator);
        $response = $this->getResponse($error);

        $response->shouldBeAnInstanceOf(JsonResponse::class);
        $response->getContent()->shouldReturn(self::EXPECTED_RESPONSE_MESSAGE);
    }
}
