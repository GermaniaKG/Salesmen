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



## Examples
```php
<?php
use Germania\Salesmen\SalesmanProviderInterface;
use Germania\Salesmen\SalesmanProviderTrait;

class Salesman implements SalesmanProviderInterface
{
	use SalesmanProviderTrait;
	
	public function __construct( $salesman_id )
	{
		$this->salesman_id = $salesman_id;
	}
}

$salesman = new Salesman( 99 );
echo $salesman->getSalesmanId(); // 99
```

```php
<?php
use Germania\Salesmen\SalesmanInterceptorsInterface;
use Germania\Salesmen\SalesmanInterceptorsTrait;

class MyOrder implements SalesmanInterceptorsInterface
{
	use SalesmanInterceptorsTrait;
}

$order  = new MyOrder;
$order->setSalesmanId( 34 );
echo $order->getSalesmanId(); // 34


```


## SalesmanFilterIterator

The **SalesmanFilterIterator** class accepts any Iterator collection and a salesman ID (or ID array) or *SalesmanProviderInterface* instance to filter for. Collection items not being an instance of *SalesmanProviderInterface* are always ignored. **Example:**

```php
use Germania\Salesmen\SalesmanFilterIterator;

// Prepare some SalesmanProviderInterface instances:
$order1 = new MyOrder; 
$order1->setSalesmanId( 1 );

$order2 = new MyOrder; 
$order2->setSalesmanId( 20 );

$order3 = new MyOrder; 
$order4->setSalesmanId( 999 );

$orders = [
	$order1,
	$order2,	
	$order3
];


// ---------------------------------------
// Filter by ID or ID array:
// ---------------------------------------

// should be '1'
$filter = new SalesmanFilterIterator( new \ArrayIterator( $orders ) , 20);
echo iterator_count($filter);

// should be '2'
$filter = new SalesmanFilterIterator( new \ArrayIterator( $orders ), array(20, 999));
echo iterator_count($filter);


// ---------------------------------------
// Filter by SalesmanProviderInterface:
// ---------------------------------------

$salesman = new Salesman( 1 );
$filter = new SalesmanFilterIterator( new \ArrayIterator( $orders ), $salesman);

// should be '1'
echo iterator_count($filter);
```



## Development

```bash
$ git clone https://github.com/GermaniaKG/Salesmen.git
$ cd Salesmen
$ composer install
```

## Unit tests

Either copy `phpunit.xml.dist` to `phpunit.xml` and adapt to your needs, or leave as is. Run [PhpUnit](https://phpunit.de/) like this:

```bash
$ vendor/bin/phpunit
```

