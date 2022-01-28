<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

namespace spec\BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\Provider\CustomTwigErrorResponseProvider;
use BitBag\SyliusMailTemplatePlugin\Response\TwigError\TwigErrorResponseInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\Error;
use Webmozart\Assert\InvalidArgumentException;

class CustomTwigErrorResponseProviderSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CustomTwigErrorResponseProvider::class);
    }

    function it_should_return_null_if_no_supported_custom_twig_error_response_found(): void
    {
        $error = new Error('foo');
        $this->provide($error)->shouldReturn(null);
    }

    function it_should_throw_exception_if_passed_object_not_implementing_the_proper_interface(): void
    {
        $responses = [new \stdClass()];
        $this->beConstructedWith($responses);

        $this->shouldThrow(InvalidArgumentException::class)->during('provide', [new Error('foo')]);
    }

    function it_should_return_first_supporting_custom_twig_error_response(
        TwigErrorResponseInterface $firstResponse,
        TwigErrorResponseInterface $secondResponse,
        TwigErrorResponseInterface $thirdResponse
    ): void {
        $error = new Error('foo');
        $firstJsonResponse = new JsonResponse();
        $secondJsonResponse = new JsonResponse();
        $thirdJsonResponse = new JsonResponse();

        $firstResponse->getResponse($error)->willReturn($firstJsonResponse);
        $firstResponse->supports($error)->willReturn(false);

        $secondResponse->getResponse($error)->willReturn($secondJsonResponse);
        $secondResponse->supports($error)->willReturn(true);

        $thirdResponse->getResponse($error)->willReturn($thirdJsonResponse);
        $thirdResponse->supports($error)->willReturn(true);

        $customResponses = [$firstResponse, $secondResponse, $thirdResponse];
        $this->beConstructedWith($customResponses);

        $providedResponse = $this->provide(new Error('foo'));

        $providedResponse->shouldBeAnInstanceOf(Response::class);
        $providedResponse->shouldBe($secondJsonResponse);
    }
}
