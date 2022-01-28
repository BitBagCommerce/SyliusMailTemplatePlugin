<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

namespace spec\BitBag\SyliusMailTemplatePlugin\Response\TwigError;

use BitBag\SyliusMailTemplatePlugin\Response\TwigError\SecurityNotAllowedFunctionErrorResponse;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Webmozart\Assert\InvalidArgumentException;

class SecurityNotAllowedFunctionErrorResponseSpec extends ObjectBehavior
{
    public const ERROR_MESSAGE_TRANSLATION = 'Function "%s" is not allowed at line %d';

    public const EXPECTED_RESPONSE_MESSAGE = '{"message":"Function \u0022bar\u0022 is not allowed at line 2"}';

    function let(TranslatorInterface $translator)
    {
        $this->beConstructedWith($translator);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(SecurityNotAllowedFunctionErrorResponse::class);
    }

    function it_should_return_true_for_supported_error(): void
    {
        $securityNotAllowedFunctionError = new SecurityNotAllowedFunctionError('foo', 'bar');
        $this->supports($securityNotAllowedFunctionError)->shouldReturn(true);
    }

    function it_should_return_false_for_unsupported_error(): void
    {
        $this->supports(new SecurityError('foo'))->shouldReturn(false);
    }

    function it_should_throw_exception_if_get_response_got_unsupported_instance_of_error(): void
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('getResponse', [new SecurityError('foo')]);
    }

    function it_should_return_response_with_proper_message(TranslatorInterface $translator): void{
        $translator->trans(SecurityNotAllowedFunctionErrorResponse::MESSAGE)->willReturn(self::ERROR_MESSAGE_TRANSLATION);
        $error = new SecurityNotAllowedFunctionError('foo', 'bar', 2);

        $this->beConstructedWith($translator);
        $response = $this->getResponse($error);

        $response->shouldBeAnInstanceOf(JsonResponse::class);
        $response->getContent()->shouldReturn(self::EXPECTED_RESPONSE_MESSAGE);
    }
}
