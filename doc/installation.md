# BitBag SyliusMailTemplatePlugin

## Installation

---

```bash
$ composer require bitbag/mailtemplate-plugin
```

1. Add plugin dependencies to your `config/bundles.php` file:
```php
return [
    ...

    BitBag\SyliusMailTemplatePlugin\BitBagSyliusMailTemplatePlugin::class => ['all' => true],
];
```

2. Import required config in your `config/packages/_sylius.yaml` file:
```yaml
# config/packages/_sylius.yaml

imports:
    ...

    - { resource: "@BitBagSyliusMailTemplatePlugin/Resources/config/config.yaml" }
```

3. Import routing in your `config/routes.yaml` file:
```yaml
# config/routes.yaml
...

bitbag_sylius_mail_template_plugin:
    resource: "@BitBagSyliusMailTemplatePlugin/Resources/config/routing.yaml"
```

4. Update your database

```
$ bin/console doctrine:migrations:migrate
```

**Note:** If you are running it on production, add the `-e prod` flag to this command.

5. Add plugin assets
    * [With webpack (recommended)](./assets-with-webpack.md)
    * [Without webpack](./assets-without-webpack.md)
