# Germania\Salesmen


[![Build Status](https://travis-ci.org/GermaniaKG/Salesmen.svg?branch=master)](https://travis-ci.org/GermaniaKG/Salesmen)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/badges/build.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Salesmen/build-status/master)


## Installation

```bash
$ composer require germania-kg/salesmen
```

## Interfaces

### SalesmanIdProviderInterface

```php
public function getSalesmanId()
```

### SalesmanIdAwareInterface

```php
extends SalesmanIdProviderInterface
public function setSalesmanId( $id )
```

## Traits

### SalesmanIdProviderTrait

Objects using this trait will provide a `salesman_id` attribute and a `getSalesmanId` getter method, as outlined here:

```php
public $salesman_id;
public function getSalesmanId()
```


### SalesmanIdAwareTrait

Objects using this trait will provide anything that **SalesmanIdProviderTrait** provides, and additionally a setter method `setSalesmanId` which accepts anything; if **SalesmanIdProviderInterface** given here, *getSalesmanId* method will be called to obtain the ID to use. Roughly outlined:

```php
use SalesmanIdProviderTrait;
public function setSalesmanId( $salesman )
```







## Examples
```php
<?php
use Germania\Salesmen\SalesmanIdProviderInterface;
use Germania\Salesmen\SalesmanIdProviderTrait;

class Salesman implements SalesmanIdProviderInterface
{
	use SalesmanIdProviderTrait;
	
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
use Germania\Salesmen\ SalesmanIdAwareInterface;
use Germania\Salesmen\SalesmanIdAwareTrait;

class MyOrder implements SalesmanIdAwareInterface
{
	use SalesmanIdAwareTrait;
}

$order  = new MyOrder;
$order->setSalesmanId( 34 );
echo $order->getSalesmanId(); // 34


```


## SalesmanFilterIterator

The **SalesmanFilterIterator** class accepts any *Iterator* collection and a salesman ID (or ID array) or *SalesmanIdProviderInterface* instance to filter for. Collection items not being an instance of *SalesmanIdProviderInterface* are always ignored. 

**Iterator:**

- instances of *SalesmanIdProviderInterface*


**Filter values:**

- Integer or string ID
- Array of integer or string IDs
- One instance of *SalesmanIdProviderInterface* – also see [issue #1][i1]


**Example:**

```php
<?php
use Germania\Salesmen\SalesmanFilterIterator;

// Prepare some SalesmanIdProviderInterface instances:
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
// Filter by SalesmanIdProviderInterface:
// ---------------------------------------

$salesman = new Salesman( 1 );
$filter = new SalesmanFilterIterator( new \ArrayIterator( $orders ), $salesman);

// should be '1'
echo iterator_count($filter);
```

## Issues

- The *SalesmanFilterIterator* should also accept an array of *SalesmanIdProviderInterface* instances as filter value. See [issue #1][i1].

Also see [full issues list.][i0]

[i0]: https://github.com/GermaniaKG/Salesmen/issues 
[i1]: https://github.com/GermaniaKG/Salesmen/issues/1 

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

