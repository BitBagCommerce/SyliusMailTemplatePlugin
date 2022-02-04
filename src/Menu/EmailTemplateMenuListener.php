<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class EmailTemplateMenuListener
{
    public function buildMenu(MenuBuilderEvent $menuBuilderEvent): void
    {
        $menu = $menuBuilderEvent->getMenu();

        $menuItem = $menu->getChild('configuration');

        if (null === $menuItem) {
            return;
        }

        $menuItem
            ->addChild('email_template', [
                'route' => 'bitbag_sylius_mail_template_plugin_admin_email_template_index',
            ])
            ->setLabel('bitbag_sylius_mail_template_plugin.ui.email_template')
            ->setLabelAttribute('icon', 'envelope');
    }
}
