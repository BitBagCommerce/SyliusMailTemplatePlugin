<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Validator;

use BitBag\SyliusMailTemplatePlugin\Controller\Action\RenderEmailPreviewAction;
use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateInterface;
use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslationInterface;
use BitBag\SyliusMailTemplatePlugin\Provider\MailPreviewDataProviderInterface;
use BitBag\SyliusMailTemplatePlugin\Request\MailPreviewRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Twig\Environment;
use Webmozart\Assert\Assert;

class IsRenderableMailContentValidator extends ConstraintValidator
{
    private Environment $twig;

    private MailPreviewDataProviderInterface $mailPreviewDataProvider;

    public function __construct(Environment $twig, MailPreviewDataProviderInterface $mailPreviewDataProvider)
    {
        $this->twig = $twig;
        $this->mailPreviewDataProvider = $mailPreviewDataProvider;
    }

    /**
     * @param string|mixed $value
     */
    public function validate($value, Constraint $constraint): void
    {
        Assert::string($value);
        Assert::isInstanceOf($constraint, IsRenderableMailContent::class);

        /** @var object|EmailTemplateTranslationInterface $validatedObject */
        $validatedObject = $this->context->getObject();
        Assert::isInstanceOf($validatedObject, EmailTemplateTranslationInterface::class);

        /** @var EmailTemplateInterface $mailTemplate */
        $mailTemplate = $validatedObject->getTranslatable();
        $templateType = $mailTemplate->getType();

        if (null === $templateType) {
            return;
        }

        $data = $this->getViewData($templateType, $value);

        try {
            $this->twig->render(RenderEmailPreviewAction::EMAIL_PREVIEW_TEMPLATE, $data);
        } catch (\Exception $exception) {
            $this->context->addViolation(IsRenderableMailContent::INVALID_CONTENT_MESSAGE, [
                '{{ error }}' => $exception->getMessage(),
            ]);
        }
    }

    private function getViewData(string $templateType, string $content): array
    {
        $previewData = $this->mailPreviewDataProvider->get($templateType)->getData();
        $requestData = [
            MailPreviewRequest::NAME => 'foo',
            MailPreviewRequest::SUBJECT => 'bar',
            MailPreviewRequest::CONTENT => $content,
            MailPreviewRequest::CSS => '',
        ];

        return array_merge($previewData, $requestData);
    }
}
