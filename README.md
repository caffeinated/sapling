Caffeinated Sapling
===================
[![Laravel 5.0](https://img.shields.io/badge/Laravel-5.0-orange.svg?style=flat-square)](http://laravel.com)
[![Laravel 5.1](https://img.shields.io/badge/Laravel-5.1-orange.svg?style=flat-square)](http://laravel.com)
[![Source](http://img.shields.io/badge/source-caffeinated/sapling-blue.svg?style=flat-square)](https://github.com/caffeinated/sapling)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

Caffeinated Sapling is originally based off of Rob Crowe's [TwigBridge](https://github.com/rcrowe/TwigBridge) package; rebuilt from the ground up (not necessarily a fork). This is meant as a learning experience to get familiar with Twig, but also as an attempt to create a lighter-weight version of TwigBridge with a primary focus on Laravel 5. For a more robust and complete package, please go check out [TwigBridge](https://github.com/rcrowe/TwigBridge)!

Quick Installation
------------------
Begin by installing the package through Composer. Depending on what version of Laravel you are using (5.0 or 5.1), you'll want to pull in the `~1.0` or `~2.0` release, respectively:

#### Laravel 5.0.x
```
composer require caffeinated/sapling=~1.0
```

#### Laravel 5.1.x
```
composer require caffeinated/sapling=~2.0
```

Once this operation is complete, simply add the service provider class to your project's `config/app.php` file:

#### Laravel 5.0.x
```php
'Caffeinated\Sapling\SaplingServiceProvider',
```

#### Laravel 5.1.x
```php
Caffeinated\Sapling\SaplingServiceProvider::class,
```
