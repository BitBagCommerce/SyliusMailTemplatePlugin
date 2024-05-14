<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusMailTemplatePlugin\EventListener;

use BitBag\SyliusMailTemplatePlugin\EventListener\NotFoundTypeCreateEmailTemplateEventListener;
use BitBag\SyliusMailTemplatePlugin\Provider\EmailCodesProviderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\DataCollectorTranslator;

class NotFoundTypeCreateEmailTemplateEventListenerSpec extends ObjectBehavior
{
    function let(
        EmailCodesProviderInterface $emailCodesProvider,
        DataCollectorTranslator $dataCollectorTranslator,
        RouterInterface $router,
        Request $request,
        ParameterBagInterface $attributes,
    ): void {
        $request->attributes = $attributes;

        $this->beConstructedWith($emailCodesProvider, $dataCollectorTranslator, $router);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(NotFoundTypeCreateEmailTemplateEventListener::class);
    }

    function it_should_do_nothing_when_route_is_not_create_email_template(
        RequestEvent $requestEvent,
        Request $request,
        ParameterBag $attributes,
        EmailCodesProviderInterface $emailCodesProvider,
    ): void {
        $requestEvent->getRequest()->willReturn($request);

        $attributes->get('_route')->shouldBeCalled()->willReturn('wrong_route');

        $emailCodesProvider->provideWithLabelsNotUsedTypes()->shouldNotBeCalled();

        $this->onKernelRequest($requestEvent);
    }

    function it_should_not_redirect_when_type_are_available_to_create_email_template(
        RequestEvent $requestEvent,
        Request $request,
        ParameterBag $attributes,
        EmailCodesProviderInterface $emailCodesProvider,
        Session $session,
        FlashBagInterface $flashBag,
    ): void {
        $requestEvent->getRequest()->willReturn($request);

        $request->getSession()->willReturn($session);

        $attributes->get('_route')
                   ->shouldBeCalled()
                   ->willReturn(NotFoundTypeCreateEmailTemplateEventListener::EMAIL_TEMPLATE_CREATE_ROUTE);

        $emailCodesProvider->provideWithLabelsNotUsedTypes()->willReturn(['contact_request']);

        $flashBag->add('foo', 'bar')->shouldNotBeCalled();
        $requestEvent->setResponse(new RedirectResponse('foo'))->shouldNotBeCalled();

        $this->onKernelRequest($requestEvent);
    }

    function it_should_redirect_when_route_is_create_email_template(
        RequestEvent $requestEvent,
        Request $request,
        ParameterBag $attributes,
        EmailCodesProviderInterface $emailCodesProvider,
        Session $session,
        FlashBagInterface $flashBag,
        RouterInterface $router,
        DataCollectorTranslator $dataCollectorTranslator,
    ): void {
        $requestEvent->getRequest()->willReturn($request);

        $request->getSession()->willReturn($session);

        $session->getFlashBag()->shouldBeCalled()->willReturn($flashBag);

        $attributes->get('_route')
                   ->shouldBeCalled()
                   ->willReturn(NotFoundTypeCreateEmailTemplateEventListener::EMAIL_TEMPLATE_CREATE_ROUTE);

        $emailCodesProvider->provideWithLabelsNotUsedTypes()->willReturn([]);

        $flashBag->add('error', 'foo')->shouldBeCalled()->willReturn('foo');

        $dataCollectorTranslator->trans(NotFoundTypeCreateEmailTemplateEventListener::DEFINED_ALL_CUSTOM_TEMPLATE)
                                ->shouldBeCalled()
                                ->willReturn('foo');

        $router->generate(NotFoundTypeCreateEmailTemplateEventListener::EMAIL_TEMPLATE_INDEX_ROUTE)
               ->willReturn('bar');

        $requestEvent->setResponse(Argument::type(RedirectResponse::class))->shouldBeCalled();

        $this->onKernelRequest($requestEvent);
    }
}
