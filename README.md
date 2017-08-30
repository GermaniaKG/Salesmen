# Germania\Salesmen


[![Build Status](https://travis-ci.org/GermaniaKG/Salesmen.svg?branch=master)](https://travis-ci.org/GermaniaKG/Salesmen)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/badges/build.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/build-status/master)


## Installation

```bash
composer require germania-kg/salesmen
```

## Interfaces

### SalesmanProviderInterface

```php
public function getSalesmanId()
```

### SalesmanInterceptorsInterface


```php
extends SalesmanProviderInterface
public function setSalesmanId( $id )
```

## Traits

### SalesmanProviderTrait

Objects using this trait will provide a `salesman_id` attribute and a `getSalesmanId` getter method, as outlined here:

```php
public $salesman_id;
public function getSalesmanId()
```

### SalesmanInterceptorsTrait

Objects using this trait will provide anything that **SalesmanProviderTrait** provides, and additionally a setter method `setSalesmanId` which accepts anything; if **SalesmanProviderInterface** given here, *getSalesmanId* method will be called. Roughly outlined:

```php
use SalesmanProviderTrait;
public function setSalesmanId( $salesman )
```

## Development

```bash
$ git clone https://github.com/GermaniaKG/Salesmen.git
$ cd Salesmen
$ composer install
```

## Testing

Either copy `phpunit.xml.dist` to `phpunit.xml` and adapt to your needs, or leave as is. Run [PhpUnit](https://phpunit.de/) like this:

```bash
$ vendor/bin/phpunit
```

