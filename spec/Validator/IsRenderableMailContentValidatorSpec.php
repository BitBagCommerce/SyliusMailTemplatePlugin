<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

namespace spec\BitBag\SyliusMailTemplatePlugin\Validator;

use BitBag\SyliusMailTemplatePlugin\Controller\Action\RenderEmailPreviewAction;
use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplate;
use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslation;
use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslationInterface;
use BitBag\SyliusMailTemplatePlugin\MailPreviewData\MailPreviewDataInterface;
use BitBag\SyliusMailTemplatePlugin\Provider\MailPreviewDataProviderInterface;
use BitBag\SyliusMailTemplatePlugin\Validator\IsRenderableMailContent;
use BitBag\SyliusMailTemplatePlugin\Validator\IsRenderableMailContentValidator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Twig\Environment;
use Twig\Sandbox\SecurityError;
use Webmozart\Assert\InvalidArgumentException;

class IsRenderableMailContentValidatorSpec extends ObjectBehavior
{
    function let(Environment $twig, MailPreviewDataProviderInterface $mailPreviewDataProvider): void
    {
        $this->beConstructedWith($twig, $mailPreviewDataProvider);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(IsRenderableMailContentValidator::class);
    }

    function it_should_throw_exception_if_value_is_not_a_string(): void
    {
        $constraint = new IsRenderableMailContent();
        $this->shouldThrow(InvalidArgumentException::class)->during('validate', [1, $constraint]);
    }

    function it_should_throw_exception_if_constraint_is_not_the_expected_class_instance(): void
    {
        $constraint = new IsTrue();
        $this->shouldThrow(InvalidArgumentException::class)->during('validate', ['', $constraint]);
    }

    function it_should_add_violation_if_exception_is_thrown_while_rendering(
        ExecutionContextInterface $context,
        environment $twig,
        MailPreviewDataProviderInterface $mailPreviewDataProvider,
        MailPreviewDataInterface $mailPreviewData
    ): void {
        $emailTemplateTranslation = $this->createEmailTemplateTranslationWithSampleEmailTemplate();

        $context->getObject()->willReturn($emailTemplateTranslation);
        $mailPreviewData->getData()->willReturn([]);
        $mailPreviewDataProvider->get(Argument::any())->willReturn($mailPreviewData);
        $twig
            ->render(RenderEmailPreviewAction::EMAIL_PREVIEW_TEMPLATE, Argument::type('array'))
            ->willThrow(new SecurityError('foo'))
        ;

        $constraint = new IsRenderableMailContent();
        $validator = new IsRenderableMailContentValidator(
            $twig->getWrappedObject(),
            $mailPreviewDataProvider->getWrappedObject()
        );
        $validator->initialize($context->getWrappedObject());

        $validator->validate('', $constraint);

        $context
            ->addViolation(IsRenderableMailContent::INVALID_CONTENT_MESSAGE, Argument::type('array'))
            ->shouldBeCalled()
        ;
    }

    function it_should_do_nothing_if_no_exception_has_been_thrown_while_rendering(
        ExecutionContextInterface $context,
        environment $twig,
        MailPreviewDataProviderInterface $mailPreviewDataProvider,
        MailPreviewDataInterface $mailPreviewData
    ): void{
        $emailTemplateTranslation = $this->createEmailTemplateTranslationWithSampleEmailTemplate();

        $context->getObject()->willReturn($emailTemplateTranslation);
        $mailPreviewData->getData()->willReturn([]);
        $mailPreviewDataProvider->get(Argument::any())->willReturn($mailPreviewData);

        $constraint = new IsRenderableMailContent();
        $validator = new IsRenderableMailContentValidator(
            $twig->getWrappedObject(),
            $mailPreviewDataProvider->getWrappedObject()
        );
        $validator->initialize($context->getWrappedObject());

        $validator->validate('', $constraint);

        $context->addViolation(Argument::any())->shouldNotBeCalled();
    }

    private function createEmailTemplateTranslationWithSampleEmailTemplate(): EmailTemplateTranslationInterface
    {
        $emailTemplate = new EmailTemplate();
        $emailTemplate->setType('foo');
        $emailTemplateTranslation = new EmailTemplateTranslation();
        $emailTemplateTranslation->setTranslatable($emailTemplate);

        return $emailTemplateTranslation;
    }
}
