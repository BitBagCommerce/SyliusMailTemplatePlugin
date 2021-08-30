<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Form\Type;

use BitBag\SyliusMailTemplatePlugin\EmailTemplateTerms\Options;
use BitBag\SyliusMailTemplatePlugin\Form\Type\Translation\EmailTemplateTranslationType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class EmailTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'bitbag_sylius_mail_template_plugin.ui.template_type',
                'choices' => Options::getAvailableEmailTemplate(),
            ])
            ->add('styleCss', TextareaType::class, [
                'label' => 'bitbag_sylius_mail_template_plugin.ui.style_css',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'label' => 'bitbag_sylius_mail_template_plugin.ui.template_contents',
                'entry_type' => EmailTemplateTranslationType::class,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_mail_template_plugin_template_email';
    }
}
