Caffeinated Sapling
===================
Caffeinated Sapling is originally based off of Rob Crowe's [TwigBridge](https://github.com/rcrowe/TwigBridge) package. This is meant as a learning experience to get familiar with Twig, but also as an attempt to create a lighter-weight version of TwigBridge with a primary focus on Laravel 5. For a more robust and complete package, please go check out [TwigBridge](https://github.com/rcrowe/TwigBridge)!

Quick Installation
------------------
Begin by installing the package through Composer. Add `caffeinated/sapling` to your composer.json file:

```
"caffeinated/sapling": "~1.0@dev"
```

Then run `composer install` to pull the package in.

Once this operation is complete, simply add the service provider class to your project's `config/app.php` file:

#### Service Provider
```
'Caffeinated\Sapling\SaplingServiceProvider',
```