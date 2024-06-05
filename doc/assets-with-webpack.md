# BitBag SyliusMailTemplatePlugin

[⬅️ Back to Installation](./installation.md)

## Overview
* [Installation - Import Webpack Config](#installation---import-webpack-config)
* [Installation - Add new entry to existing configs](#installation---add-new-entry-to-existing-configs)
* [Installation - Add new entry to existing configs](#installation---add-new-entry-to-existing-configs)
* [Installation - Add new entry to existing configs](#installation---add-new-entry-to-existing-configs)

## Installation - Import Webpack Config

- ✔️ Completely independent configuration
- ✔️ No need to add plugin assets globally (you can add it to specific pages)

1. Import plugin's `webpack.config.js` file

```js
// webpack.config.js
const [ bitbagMailTemplateShop, bitbagMailTemplateAdmin ] = require('./vendor/bitbag/mailtemplate-plugin/webpack.config.js')
...

module.exports = [..., bitbagMailTemplateShop, bitbagMailTemplateAdmin];
```

2. Add new packages in `./config/packages/assets.yaml`

```yml
# config/packages/assets.yaml

framework:
    assets:
        packages:
            # ...
            mail_template_shop:
                json_manifest_path: '%kernel.project_dir%/public/build/bitbag/mailtemplate/shop/manifest.json'
            mail_template_admin:
                json_manifest_path: '%kernel.project_dir%/public/build/bitbag/mailtemplate/admin/manifest.json'
```

3. Add new build paths in `./config/packages/webpack_encore.yml`

```yml
# config/packages/webpack_encore.yml

webpack_encore:
    builds:
        # ...
        mail_template_shop: '%kernel.project_dir%/public/build/bitbag/mailtemplate/shop'
        mail_template_admin: '%kernel.project_dir%/public/build/bitbag/mailtemplate/admin'
```

4. Add encore functions to your templates

```twig
{# @SyliusShopBundle/_scripts.html.twig #}
{{ encore_entry_script_tags('bitbag-mailtemplate-shop', null, 'mail_template_shop') }}

{# @SyliusShopBundle/_styles.html.twig #}
{{ encore_entry_link_tags('bitbag-mailtemplate-shop', null, 'mail_template_shop') }}

{# @SyliusAdminBundle/_scripts.html.twig #}
{{ encore_entry_script_tags('bitbag-mailtemplate-admin', null, 'mail_template_admin') }}

{# @SyliusAdminBundle/_styles.html.twig #}
{{ encore_entry_link_tags('bitbag-mailtemplate-admin', null, 'mail_template_admin') }}
```

5. [Add packages](./assets-packages.md)

6. Run `yarn encore dev` or `yarn encore production`

## Installation - Add new entry to existing configs

- ✔️ Same webpack configuration for plugin and project assets
- ✔️ No need to add plugin assets globally (you can add it to specific pages)

<br>

1. Add new entries to your `webpack.config.js`
```js
// ./webpack.config.js

// Shop config
    .addEntry('bitbag-mailtemplate-shop', 'vendor/bitbag/mailtemplate-plugin/src/Resources/assets/shop/entry.js')

// Admin config
    .addEntry('bitbag-mailtemplate-admin', 'vendor/bitbag/mailtemplate-plugin/src/Resources/assets/admin/entry.js')
```

2. Add encore functions to your templates

```twig
{# @SyliusShopBundle/_scripts.html.twig #}
{{ encore_entry_script_tags('bitbag-mailtemplate-shop', null, 'shop') }}

{# @SyliusShopBundle/_styles.html.twig #}
{{ encore_entry_link_tags('bitbag-mailtemplate-shop', null, 'shop') }}

{# @SyliusAdminBundle/_scripts.html.twig #}
{{ encore_entry_script_tags('bitbag-mailtemplate-admin', null, 'admin') }}

{# @SyliusAdminBundle/_styles.html.twig #}
{{ encore_entry_link_tags('bitbag-mailtemplate-admin', null, 'admin') }}
```

3. [Add packages](./assets-packages.md)

4. Run `yarn encore dev` or `yarn encore production`

## Installation - Import plugin entry into existing project entry.js files

- ✔️ Same webpack configuration for plugin and project assets
- ✔️ No need to edit templates - it's good for quick testing
- ⚠ Assets are loaded globally which can affect page speed

<br>

1. Just add these imports into your entry.js files

```js
// ./assets/shop/entry.js
import '../../vendor/bitbag/mailtemplate-plugin/src/Resources/assets/shop/entry.js';

// ./assets/admin/entry.js
import '../../vendor/bitbag/mailtemplate-plugin/src/Resources/assets/admin/entry.js';
```

2.  [Add packages](./assets-packages.md)

## Installation - Custom solution

If none of the previous methods work for your project, you can write your own encore configuration:

Main entry points:

```js
// shop
.addEntry('/vendor/bitbag/mailtemplate-plugin/src/Resources/assets/shop/entry.js')

// admin
.addEntry('/vendor/bitbag/mailtemplate-plugin/src/Resources/assets/admin/entry.js')
```

Style entry points:

```js
// shop
.addStyleEntry('/vendor/bitbag/mailtemplate-plugin/src/Resources/assets/shop/scss/main.scss')

// admin
.addStyleEntry('/vendor/bitbag/mailtemplate-plugin/src/Resources/assets/admin/scss/main.scss')
```

---

More information: [Advanced Webpack Config](https://symfony.com/doc/current/frontend/encore/advanced-config.html)
