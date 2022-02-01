# BitBag SyliusMailTemplatePlugin

[⬅️ Back to Installation](./installation.md)

## Overview
* [Installation - Non-webpack solution](#installation---non-webpack-solution)

## Installation - Non-webpack solution

- ✔️ No need to have a bundler on the project
- ✔️ No need to add plugin assets globally (you can add it to specific pages)
- ✖️ No possibility to edit/extend assets

<br>

1. Instal plugin assets using:

```bash
$ bin/console assets:install
```

2. Add twig inclusions in your templates:
```twig
{# @SyliusAdminBundle/_scripts.html.twig #}
{% include '@SyliusUi/_javascripts.html.twig' with {
    'path': 'bundles/bitbagsyliusmailtemplatesplugin/bitbag-mailtemplates-admin.js'
} %}

{# @SyliusAdminBundle/_styles.html.twig #}
{% include '@SyliusUi/_stylesheets.html.twig' with {
    'path': 'bundles/bitbagsyliusmailtemplatesplugin/bitbag-mailtemplates-admin.css'
} %}

{# @SyliusShopBundle/_scripts.html.twig #}
{% include '@SyliusUi/_javascripts.html.twig' with {
    'path': 'bundles/bitbagsyliusmailtemplatesplugin/bitbag-mailtemplates-shop.js'
} %}

{# @SyliusShopBundle/_styles.html.twig #}
{% include '@SyliusUi/_stylesheets.html.twig' with {
    'path': 'bundles/bitbagsyliusmailtemplatesplugin/bitbag-mailtemplates-shop.css'
} %}
```
