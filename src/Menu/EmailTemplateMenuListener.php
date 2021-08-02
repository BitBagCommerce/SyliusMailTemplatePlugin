<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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

        $menuItem
            ->addChild('email_template', [
                'route' => 'bitbag_sylius_mail_template_plugin_admin_email_template_index',
            ])
            ->setLabel('bitbag_sylius_mail_template_plugin.ui.email_template')
            ->setLabelAttribute('icon', 'envelope');
    }
}
