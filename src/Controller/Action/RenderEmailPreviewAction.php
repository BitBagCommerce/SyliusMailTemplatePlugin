<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Controller\Action;

use BitBag\SyliusMailTemplatePlugin\Provider\MailPreviewDataProviderInterface;
use BitBag\SyliusMailTemplatePlugin\Request\MailPreviewRequest;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class RenderEmailPreviewAction
{
    public const EMAIL_PREVIEW_TEMPLATE = '@BitBagSyliusMailTemplatePlugin/Admin/Email/Preview/previewTemplate.html.twig';

    private Environment $twig;

    private MailPreviewDataProviderInterface $mailPreviewDataProvider;

    public function __construct(Environment $twig, MailPreviewDataProviderInterface $mailPreviewDataProvider)
    {
        $this->twig = $twig;
        $this->mailPreviewDataProvider = $mailPreviewDataProvider;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(MailPreviewRequest $request): Response
    {
        $requestData = $request->toArray();
        $mailPreviewData = $this->mailPreviewDataProvider->get($request->getTemplate());
        $data = array_merge($requestData, $mailPreviewData->getData());

        $mailPreview = $this->twig->render(self::EMAIL_PREVIEW_TEMPLATE, $data);

        return new Response($mailPreview);
    }
}
