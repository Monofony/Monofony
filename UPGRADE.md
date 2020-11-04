## UPGRADE FOR `0.4.x`

### FROM `0.2.x` TO `0.4.x`

First use composer 2 using these commands:
```bash
composer self-update
composer self -v
```

Ensure you requires Symfony 4.4.*:
```bash
composer config extra.symfony.require "4.4.*"
```

Ensure you use stable releases:
```bash
composer config minimum-stability "stable"
```

Update your dependencies:
```bash
composer remove \
    monofony/api-bundle \
    monofony/front-bundle \
    monofony/admin-bundle \
    monofony/core-bundle \
    monofony/fixtures-plugin \
    --no-update --no-scripts --no-plugins
```

```bash
composer require \
    php:^7.3 \
    monofony/core-pack \
    monofony/api-pack \
    monofony/admin-pack \
    monofony/front-pack \
    symfony/dotenv:4.4.* \
    symfony/flex:^1.9 \
    symfony/monolog-bundle:^3.1 \
    symfony/webpack-encore-bundle:^1.7 \
    --no-update --no-scripts --no-plugins
```

```bash
composer require --dev monofony/test-pack:^0.4 --no-update --no-scripts --no-plugins
```

```bash
composer require \
    eightpoints/guzzle-bundle:^7.3 \
    sensio/framework-extra-bundle:^5.1 \
    sensiolabs/security-checker:^5.0 \
    sylius/mailer-bundle \
    twig/extensions \
    --no-update --no-scripts --no-plugins
```

Copy the script to migrate the code:
```bash
php -r "copy('https://raw.githubusercontent.com/Monofony/Monofony/0.x/bin/upgrade-to-0.4', 'bin/upgrade-to-0.4');"
```

Make it executuable:
```bash
chmod a+x bin/upgrade-to-0.4
```

Run it:
```bash
bin/upgrade-to-0.4
```

And finally run composer update:
```bash
composer update
```
