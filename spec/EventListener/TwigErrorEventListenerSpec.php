<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusMailTemplatePlugin\EventListener;

use BitBag\SyliusMailTemplatePlugin\EventListener\TwigErrorEventListener;
use BitBag\SyliusMailTemplatePlugin\Provider\CustomTwigErrorResponseProviderInterface;
use PhpSpec\ObjectBehavior;
use function PHPUnit\Framework\assertSame;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Twig\Error\Error;

final class TwigErrorEventListenerSpec extends ObjectBehavior
{
    function let(CustomTwigErrorResponseProviderInterface $customTwigErrorResponseProvider): void
    {
        $this->beConstructedWith($customTwigErrorResponseProvider);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(TwigErrorEventListener::class);
    }

    function it_should_do_nothing_if_exception_is_not_a_twig_security_error(
        HttpKernelInterface $httpKernel,
        Request $request,
        CustomTwigErrorResponseProviderInterface $customTwigErrorResponseProvider,
    ): void {
        $exceptionEvent = new ExceptionEvent(
            $httpKernel->getWrappedObject(),
            $request->getWrappedObject(),
            HttpKernelInterface::MASTER_REQUEST,
            new \Exception(),
        );
        $customTwigErrorResponseProvider->provide(Argument::type(Error::class))->shouldNotBeCalled();

        $this->onKernelException($exceptionEvent);
    }

    function it_should_do_nothing_if_provided_custom_response_is_null(
        HttpKernelInterface $httpKernel,
        Request $request,
        CustomTwigErrorResponseProviderInterface $customTwigErrorResponseProvider,
    ): void {
        $genericResponse = new Response();
        $exceptionEvent = new ExceptionEvent(
            $httpKernel->getWrappedObject(),
            $request->getWrappedObject(),
            HttpKernelInterface::MASTER_REQUEST,
            new \Exception(),
        );
        $exceptionEvent->setResponse($genericResponse);
        $customTwigErrorResponseProvider->provide(Argument::type(Error::class))->willReturn(null);

        $this->onKernelException($exceptionEvent);

        assertSame($genericResponse, $exceptionEvent->getResponse());
    }

    function it_should_set_response_to_the_provided_custom_twig_error_response(
        HttpKernelInterface $httpKernel,
        Request $request,
        CustomTwigErrorResponseProviderInterface $customTwigErrorResponseProvider,
    ): void {
        $jsonResponse = new JsonResponse();
        $error = new Error('foo');
        $exceptionEvent = new ExceptionEvent(
            $httpKernel->getWrappedObject(),
            $request->getWrappedObject(),
            HttpKernelInterface::MASTER_REQUEST,
            $error,
        );
        $exceptionEvent->setResponse(new Response());
        $customTwigErrorResponseProvider->provide($error)->willReturn($jsonResponse);

        $this->onKernelException($exceptionEvent);

        assertSame($jsonResponse, $exceptionEvent->getResponse());
    }
}
