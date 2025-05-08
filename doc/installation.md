# Installation

## Overview:
GENERAL
- [Requirements](#requirements)
- [Composer](#composer)
- [Basic configuration](#basic-configuration)
---
FRONTEND
- [Webpack](#webpack)
---
ADDITIONAL
- [Known Issues](#known-issues)
---

## Requirements:
We work on stable, supported and up-to-date versions of packages. We recommend you to do the same.

| Package       | Version         |
|---------------|-----------------|
| PHP           | \>=8.0          |
| sylius/sylius | 1.13.x - 1.14.x |
| MySQL         | \>= 5.7         |
| NodeJS        | \>= 14.x        |

## Composer:
```bash
composer require bitbag/mailtemplate-plugin --no-scripts
```

## Basic configuration:
Add plugin dependencies to your `config/bundles.php` file:

```php
# config/bundles.php

return [
    ...
    BitBag\SyliusMailTemplatePlugin\BitBagSyliusMailTemplatePlugin::class => ['all' => true],
];
```

Import required config in your `config/packages/_sylius.yaml` file:

```yaml
# config/packages/_sylius.yaml

imports:
    ...
    - { resource: "@BitBagSyliusMailTemplatePlugin/Resources/config/config.yaml" }
```

Add routing to your `config/routes.yaml` file:
```yaml
# config/routes.yaml

bitbag_sylius_mail_template_plugin:
    resource: "@BitBagSyliusMailTemplatePlugin/Resources/config/routing.yaml"
```

### Update your database
Please run migrations by using command:
```bash
bin/console doctrine:migrations:migrate
```

**Note:** If you are running it on production, add the `-e prod` flag to this command.

### Clear application cache by using command:
```bash
bin/console cache:clear
```
**Note:** If you are running it on production, add the `-e prod` flag to this command.

## Webpack

### NPM dependencies installation

Please install the dependencies that plugin uses:

```bash
yarn add axios
yarn add codemirror@5
```

If your node version disallows to install any of above dependencies, please allow to install legacy versions by using the command:

```bash
npm config set legacy-peer-deps true
```

### Webpack.config.js

Please setup your `webpack.config.js` file to require the plugin's webpack configuration. To do so, please put the line below somewhere on top of your webpack.config.js file:
```js
const [ bitbagMailTemplateShop, bitbagMailTemplateAdmin ] = require('./vendor/bitbag/mailtemplate-plugin/webpack.config.js');
```
As next step, please add the imported consts into final module exports:
```js
module.exports = [..., bitbagMailTemplateShop, bitbagMailTemplateAdmin];
```

### Assets
Add the asset configuration into `config/packages/assets.yaml`:
```yaml
framework:
    assets:
        packages:
            ...
            mail_template_shop:
                json_manifest_path: '%kernel.project_dir%/public/build/bitbag/mailtemplate/shop/manifest.json'
            mail_template_admin:
                json_manifest_path: '%kernel.project_dir%/public/build/bitbag/mailtemplate/admin/manifest.json'
```

### Webpack Encore
Add the webpack configuration into `config/packages/webpack_encore.yaml`:

```yaml
webpack_encore:
    output_path: '%kernel.project_dir%/public/build/default'
    builds:
        ...
        mail_template_shop: '%kernel.project_dir%/public/build/bitbag/mailtemplate/shop'
        mail_template_admin: '%kernel.project_dir%/public/build/bitbag/mailtemplate/admin'
```

### Encore functions
Add encore functions to your templates:

SyliusAdminBundle:
```php
{# @SyliusAdminBundle/_scripts.html.twig #}
{{ encore_entry_script_tags('bitbag-mailtemplate-admin', null, 'mail_template_admin') }}

{# @SyliusAdminBundle/_styles.html.twig #}
{{ encore_entry_link_tags('bitbag-mailtemplate-admin', null, 'mail_template_admin') }}
```
SyliusShopBundle:
```php
{# @SyliusShopBundle/_scripts.html.twig #}
{{ encore_entry_script_tags('bitbag-mailtemplate-shop', null, 'mail_template_shop') }}

{# @SyliusShopBundle/_styles.html.twig #}
{{ encore_entry_link_tags('bitbag-mailtemplate-shop', null, 'mail_template_shop') }}
```

### Run commands
```bash
yarn install
yarn encore dev # or prod, depends on your environment
```

## Known issues
### Translations not displaying correctly
For incorrectly displayed translations, execute the command:
```bash
bin/console cache:clear
```
