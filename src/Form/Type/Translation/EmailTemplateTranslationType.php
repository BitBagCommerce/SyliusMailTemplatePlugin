<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Form\Type\Translation;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class EmailTemplateTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'bitbag_sylius_mail_template_plugin.ui.template_name',
            ])
            ->add('subject', TextType::class, [
                'label' => 'bitbag_sylius_mail_template_plugin.ui.template_subject',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'bitbag_sylius_mail_template_plugin.ui.template_content',
                'attr' => [
                    'class' => 'codemirror-editor',
                    'data-language' => 'htmlmixed',
                ],
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_mail_template_plugin_template_email_translation';
    }
}
