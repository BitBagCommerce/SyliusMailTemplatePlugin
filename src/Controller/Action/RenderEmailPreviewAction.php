<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Controller\Action;

use BitBag\SyliusMailTemplatePlugin\MailPreviewDataProvider\MailPreviewDataProviderInterface;
use BitBag\SyliusMailTemplatePlugin\Request\MailPreviewRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedMethodError;
use Twig\Sandbox\SecurityNotAllowedPropertyError;
use Twig\Sandbox\SecurityNotAllowedTagError;

final class RenderEmailPreviewAction
{
    public const EMAIL_PREVIEW_TEMPLATE = '@BitBagSyliusMailTemplatePlugin/Admin/Email/Preview/previewTemplate.html.twig';

    private Environment $twig;

    private MailPreviewDataProviderInterface $mailPreviewDataProvider;

    private TranslatorInterface $translator;

    public function __construct(
        Environment $twig,
        MailPreviewDataProviderInterface $mailPreviewDataProvider,
        TranslatorInterface $translator
    ){
        $this->twig = $twig;
        $this->mailPreviewDataProvider = $mailPreviewDataProvider;
        $this->translator = $translator;
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

    /**
     * @throws \Exception
     */
    private function handleException(\Exception $exception): Response
    {
        switch (get_class($exception)) {
            case SecurityNotAllowedFunctionError::class:
                return $this->handleNotAllowedFunctionError($exception);
            case SecurityNotAllowedMethodError::class:
                return $this->handleNotAllowedMethodError($exception);
            case SecurityNotAllowedFilterError::class:
                return $this->handleNotAllowedFilterError($exception);
            case SecurityNotAllowedTagError::class:
                return $this->handleNotAllowedTagError($exception);
            case SecurityNotAllowedPropertyError::class:
                return $this->handleNotAllowedPropertyError($exception);
            default:
                throw $exception;
        }
    }

    private function handleNotAllowedFunctionError(SecurityNotAllowedFunctionError $exception): Response
    {
        $message = sprintf(
            $this->translator->trans('bitbag_sylius_mail_template_plugin.ui.not_allowed_twig_function'),
            $exception->getFunctionName(),
            $exception->getTemplateLine()
        );

        return $this->createJsonResponse($message);
    }

    private function handleNotAllowedMethodError(SecurityNotAllowedMethodError $exception): Response
    {
        $message = sprintf(
            $this->translator->trans('bitbag_sylius_mail_template_plugin.ui.not_allowed_twig_method'),
            $exception->getMethodName(),
            $exception->getTemplateLine()
        );

        return $this->createJsonResponse($message);
    }

    private function handleNotAllowedFilterError(SecurityNotAllowedFilterError $exception): Response
    {
        $message = sprintf(
            $this->translator->trans('bitbag_sylius_mail_template_plugin.ui.not_allowed_twig_filter'),
            $exception->getFilterName(),
            $exception->getTemplateLine()
        );

        return $this->createJsonResponse($message);
    }

    private function handleNotAllowedTagError(SecurityNotAllowedTagError $exception): Response
    {
        $message = sprintf(
            $this->translator->trans('bitbag_sylius_mail_template_plugin.ui.not_allowed_twig_tag'),
            $exception->getTagName(),
            $exception->getTemplateLine()
        );

        return $this->createJsonResponse($message);
    }

    private function handleNotAllowedPropertyError(SecurityNotAllowedPropertyError $exception): Response
    {
        $message = sprintf(
            $this->translator->trans('bitbag_sylius_mail_template_plugin.ui.not_allowed_twig_property'),
            $exception->getPropertyName(),
            $exception->getTemplateLine()
        );

        return $this->createJsonResponse($message);
    }

    private function createJsonResponse(string $message): JsonResponse
    {
        return new JsonResponse([
            'message' => $message,
        ], Response::HTTP_BAD_REQUEST);
    }
}
