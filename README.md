# Akhan Modules
[![Laravel 5.4](https://img.shields.io/badge/Laravel-5.4-orange.svg?style=flat-square)](http://laravel.com)
[![Source](http://img.shields.io/badge/source-caffeinated/modules-blue.svg?style=flat-square)](https://github.com/caffeinated/modules)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

Akhan Modules based on package Caffeinated and this is a simple package to allow the means to separate your Laravel 5.4 application out into modules. Each module is completely self-contained allowing the ability to simply drop a module in for use.

The package follows the FIG standards PSR-1, PSR-2, and PSR-4 to ensure a high level of interoperability between shared PHP code.

## Documentation
You will find user friendly and updated documentation in the wiki here: [Caffeinated Modules Wiki](https://github.com/caffeinated/modules/wiki)

## Quick Installation
Begin by installing the package through Composer.

```
composer require akhan/modules
```

Once this operation is complete, simply add both the service provider and facade classes to your project's `config/app.php` file:

#### Service Provider

```php
Akhan\Modules\ModulesServiceProvider::class,
```

#### Facade

```php
'Module' => Akhan\Modules\Facades\Module::class,
```

And that's it! With your coffee in reach, start building out some awesome modules!
