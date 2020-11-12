<img src="https://static.germania-kg.com/logos/ga-logo-2016-web.svgz" width="250px">

------



# Germania KG · MergeQueryUriFactory



[![Packagist](https://img.shields.io/packagist/v/germania-kg/mergequery_urifactory.svg?style=flat)](https://packagist.org/packages/germania-kg/mergequery_urifactory)
[![PHP version](https://img.shields.io/packagist/php-v/germania-kg/mergequery_urifactory.svg)](https://packagist.org/packages/germania-kg/mergequery_urifactory)
[![Build Status](https://img.shields.io/travis/GermaniaKG/MergeQueryUriFactory.svg?label=Travis%20CI)](https://travis-ci.org/GermaniaKG/MergeQueryUriFactory)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GermaniaKG/MergeQueryUriFactory/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/MergeQueryUriFactory/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/GermaniaKG/MergeQueryUriFactory/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/MergeQueryUriFactory/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/GermaniaKG/MergeQueryUriFactory/badges/build.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/MergeQueryUriFactory/build-status/master)



## Installation

```bash
$ composer require germania-kg/mergequery_urifactory
```



## Usage:

The **MergeQueryUriFactoryDecorator** adds a `createUriMergeQuery` method to any given PSR-17 UriFactory. It also itself implements `Psr\Http\Message\UriFactoryInterface` and can also be used as `callable`.

The `createUriMergeQuery` accepts both *string* and *UriInterface* URIs.

```php
<?php
use Germania\MergeQueryUriFactory\MergeQueryUriFactoryDecorator;
use Nyholm\Psr7\Factory\Psr17Factory;  

$decoratee = new Psr17Factory();
$uri_factory = new MergeQueryUriFactoryDecorator( $decoratee );

// You know the UriFactoryInterface:
$uri = $uri_factory->createUri( 'http://httpbin.org' );

// Programmatically merge query parameters,
// either to a string or UriInterface:
$uri2 = $uri_factory->createUriMergeQuery( 'http://httpbin.org', ['foo' => 'bar']);
$uri3 = $uri_factory->createUriMergeQuery( $uri, ['foo' => 'bar']);

echo $uri3;
// http://httpbin.org?foo=bar
```



