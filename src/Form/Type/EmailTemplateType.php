<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Form\Type;

use BitBag\SyliusMailTemplatePlugin\Form\Type\Translation\EmailTemplateTranslationType;
use BitBag\SyliusMailTemplatePlugin\Provider\EmailCodesProviderInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class EmailTemplateType extends AbstractType
{
    public const TYPE_FIELD_NAME = 'type';

    public const STYLE_CSS_FIELD_NAME = 'styleCss';

    public const TRANSLATIONS_FIELD_NAME = 'translations';

    public const TEMPLATE_TYPE_LABEL = 'bitbag_sylius_mail_template_plugin.ui.template_type';

    public const STYLE_CSS_LABEL = 'bitbag_sylius_mail_template_plugin.ui.style_css';

    public const TRANSLATIONS_LABEL = 'bitbag_sylius_mail_template_plugin.ui.template_contents';

    public const BLOCK_PREFIX = 'bitbag_sylius_mail_template_plugin_template_email';

    public const MAIL_TEMPLATE_TYPE_DOMAIN = 'mail_template_type';

    private EmailCodesProviderInterface $emailCodesProvider;

    public function __construct(EmailCodesProviderInterface $emailCodesProvider)
    {
        $this->emailCodesProvider = $emailCodesProvider;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE_FIELD_NAME, ChoiceType::class, [
                'label' => self::TEMPLATE_TYPE_LABEL,
                'choices' => $this->emailCodesProvider->getAvailableEmailTemplateTypes($options['data']),
                'choice_translation_domain' => 'mail_template_type',
            ])
            ->add(self::STYLE_CSS_FIELD_NAME, TextareaType::class, [
                'label' => self::STYLE_CSS_LABEL,
                'required' => false,
                'attr' => [
                    'class' => 'codemirror-editor',
                    'data-language' => 'css',
                ],
            ])
            ->add(self::TRANSLATIONS_FIELD_NAME, ResourceTranslationsType::class, [
                'label' => self::TRANSLATIONS_LABEL,
                'entry_type' => EmailTemplateTranslationType::class,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return self::BLOCK_PREFIX;
    }
}
