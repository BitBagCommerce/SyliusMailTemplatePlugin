<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\EventListener;

use BitBag\SyliusMailTemplatePlugin\Provider\EmailCodesProviderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\DataCollectorTranslator;

final class NotFoundTypeCreateEmailTemplateEventListener
{
    public const EMAIL_TEMPLATE_INDEX_ROUTE = 'bitbag_sylius_mail_template_plugin_admin_email_template_index';

    public const EMAIL_TEMPLATE_CREATE_ROUTE = 'bitbag_sylius_mail_template_plugin_admin_email_template_create';

    public const DEFINED_ALL_CUSTOM_TEMPLATE = 'bitbag_sylius_mail_template_plugin.ui.all_types_have_defined_custom_template';

    private EmailCodesProviderInterface $emailCodesProvider;

    private DataCollectorTranslator $translator;

    private RouterInterface $router;

    public function __construct(
        EmailCodesProviderInterface $emailCodesProvider,
        DataCollectorTranslator $translator,
        RouterInterface $router
    ) {
        $this->emailCodesProvider = $emailCodesProvider;
        $this->translator = $translator;
        $this->router = $router;
    }

    public function onKernelRequest(RequestEvent $requestEvent): void
    {
        $session = $requestEvent->getRequest()->getSession();

        if (self::EMAIL_TEMPLATE_CREATE_ROUTE === $requestEvent->getRequest()->attributes->get('_route')) {
            $provideWithLabels = $this->emailCodesProvider->provideWithLabelsNotUsedTypes();
            if (0 === count($provideWithLabels) && $session instanceof Session) {
                $session->getFlashBag()->add('error', $this->translator->trans(self::DEFINED_ALL_CUSTOM_TEMPLATE));

                $requestEvent->setResponse(new RedirectResponse($this->router->generate(self::EMAIL_TEMPLATE_INDEX_ROUTE)));
            }
        }
    }
}
