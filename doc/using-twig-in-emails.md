# BitBag SyliusMailTemplatePlugin

## Using Twig in emails

---

### Security
Twig templating engine is a powerful tool but in case of creating email templates might be too powerful. To prevent insecure usage of Twig we have limited the access to the Twig functions and filters.
Default configuration is following:
```yaml
bit_bag_sylius_mail_template:
    twig:
        allowed_filters: []
        allowed_functions: []
        allowed_methods:
            '*': '*'
        allowed_properties: []
        allowed_tags: []
```
**NOTE:** To prevent errors caused by configuration overriding we have made the following options always enabled:
* Tags: `apply`
* Filters: `nl2br`, `inky_to_html`, `escape`
* Functions: `include`, `template_from_string`

While configuring `allowed_methods` we can use wildcard (`*`) to configure access easier.
* We can allow all methods on all objects
```yaml
bit_bag_sylius_mail_template:
    twig:
        allowed_methods:
            '*': '*'
```
* All methods on a concrete object
```yaml
bit_bag_sylius_mail_template:
    twig:
        allowed_methods:
            'Sylius\Component\Core\Model\ShipmentInterface': '*'
```
* Single method on all objects
```yaml
bit_bag_sylius_mail_template:
    twig:
        allowed_methods:
            '*':
                - 'getName'`
```

### Available variables
The set of available variables depends on a type of email. There's a list of available variables for each type of email available by default in Sylius 1.10.

* Order confirmation
```php
'order' // Sylius\Component\Core\Model\Order instance
'channel' // Sylius\Component\Channel\Model\Channel instance
'localeCode' // locale e.g. en_US
```

* Order confirmation resent
```php
'order' // Sylius\Component\Core\Model\Order instance
'channel' // Sylius\Component\Channel\Model\Channel instance
'localeCode' // locale e.g. en_US
```

* Shipment confirmation
```php
'shipment' // Sylius\Component\Core\Model\Shipment instance
'order' // Sylius\Component\Core\Model\Order instance
'channel' // Sylius\Component\Channel\Model\Channel instance
'localeCode' // locale e.g. en_US
```

* User registration
```php
'user' // Sylius\Component\Core\Model\ShopUser instance
'channel' // Sylius\Component\Channel\Model\Channel instance
'localeCode' // locale e.g. en_US
```

* Account verification token
```php
'user' // Sylius\Component\Core\Model\ShopUser instance
'channel' // Sylius\Component\Channel\Model\Channel instance
'localeCode' // locale e.g. en_US
```

* Password reset
```php
'user' // Sylius\Component\Core\Model\ShopUser instance
'channel' // Sylius\Component\Channel\Model\Channel instance
'localeCode' // locale e.g. en_US
```

* Contact request
```php
'data' // array ['email' => 'email from the form', 'message' => 'message from the form']
'channel' // Sylius\Component\Channel\Model\Channel instance
'localeCode' // locale e.g. en_US
```
