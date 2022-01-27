<?php

namespace spec\BitBag\SyliusMailTemplatePlugin\Response\TwigError;

use BitBag\SyliusMailTemplatePlugin\Response\TwigError\SecurityNotAllowedFilterErrorResponse;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Webmozart\Assert\InvalidArgumentException;

class SecurityNotAllowedFilterErrorResponseSpec extends ObjectBehavior
{
    public const ERROR_MESSAGE_TRANSLATION = 'Filter "%s" is not allowed at line %d';

    public const EXPECTED_RESPONSE_MESSAGE = '{"message":"Filter \u0022bar\u0022 is not allowed at line 2"}';

    function let(TranslatorInterface $translator)
    {
        $this->beConstructedWith($translator);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(SecurityNotAllowedFilterErrorResponse::class);
    }

    function it_should_return_true_for_supported_error(): void
    {
        $securityNotAllowedFilterError = new SecurityNotAllowedFilterError('foo', 'bar');
        $this->supports($securityNotAllowedFilterError)->shouldReturn(true);
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
        $translator->trans(SecurityNotAllowedFilterErrorResponse::MESSAGE)->willReturn(self::ERROR_MESSAGE_TRANSLATION);
        $error = new SecurityNotAllowedFilterError('foo', 'bar', 2);

        $this->beConstructedWith($translator);
        $response = $this->getResponse($error);

        $response->shouldBeAnInstanceOf(JsonResponse::class);
        $response->getContent()->shouldReturn(self::EXPECTED_RESPONSE_MESSAGE);
    }
}
