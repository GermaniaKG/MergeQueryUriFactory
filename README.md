<img src="https://static.germania-kg.com/logos/ga-logo-2016-web.svgz" width="250px">

------



# Germania KG · MergeQueryUriFactory



## Usage:

The **MergeQueryUriFactoryDecorator** adds a `createUriMergeQuery` method to any given PSR-17 UriFactory. It also itself implements `Psr\Http\Message\UriFactoryInterface`.

The `createUriMergeQuery` accepts both *string* and *UriInterface* URIs.

```php
<?php
use Germania\MergeQueryUriFactory\MergeQueryUriFactoryDecorator;
use Nyholm\Psr7\Factory\Psr17Factory;  

$decoratee = new Psr17Factory();
$uri_factory = new MergeQueryUriFactoryDecorator( $decoratee );

// You know the UriFactoryInterface:
$uri = $uri_factory->createUri( 'http://httpbin.org' );

// Programmatically merge query parameters:
$uri2 = $uri_factory->createUriMergeQuery( 'http://httpbin.org', [
  'foo' => 'bar'
]);

echo $uri2;
// http://httpbin.org?foo=bar
```



## Installation

```bash
$ composer require germania-kg/mergequery_urifactory
```



