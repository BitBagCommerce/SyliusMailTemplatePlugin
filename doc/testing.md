# BitBag SyliusMailTemplatePlugin

## Testing

```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn build
$ bin/console assets:install public -e test
$ bin/console doctrine:schema:create -e test
$ bin/console server:run 127.0.0.1:8080 -d public -e test
$ open http://localhost:8080
$ cd ../..
$ vendor/bin/behat
$ vendor/bin/phpspec run
```
## Testing emails with quick docker setup

Steps to use mailhog docker image
- create `tests/Application/.env.local`
- copy content from `tests/Application/.env`
- `MAILER_DSN=null://null` -> comment this line
- `#MAILER_DSN=smtp://localhost:1025` -> uncomment this line
- remember to match port with docker image - by default they are set to 1025
- start docker image with `docker-compose -f docker-compose.yml up`
- you can access mailhog UI on second mapped port - by default 8025

