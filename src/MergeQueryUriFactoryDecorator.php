<?php
namespace Germania\MergeQueryUriFactory;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * This UriFactory decorator builds an UriInterface
 * from an URL string and an Query String Parameters array.
 *
 * The `createUriMergeQuery` method accepts an array wit additional query params
 * that will be 'merged' into the resulting UriInterface.
 */
class MergeQueryUriFactoryDecorator implements UriFactoryInterface
{


    /**
     * @var UriFactoryInterface
     */
    public $uri_factory;


    /**
     * @param UriFactoryInterface $uri_factory
     */
    public function __construct(UriFactoryInterface $uri_factory)
    {
        $this->uri_factory = $uri_factory;
    }


    /**
     * @inheritDoc
     */
    public function createUri(string $uri = '') : UriInterface
    {
        return $this->uri_factory->createUri($uri);
    }


    /**
     * @param  string $url              URL string
     * @param  array  $query_params  Overriding query parameters
     * @return UriInterface             New URI
     */
    public function createUriMergeQuery( string $url, array $query_params = array() ) : UriInterface
    {
        $target_uri = $this->createUri($url);

        // Merge redirect params into original parameters
        parse_str($target_uri->getQuery(), $target_params);
        $merged_params = array_merge($target_params, $query_params);

        $merged_query = http_build_query($merged_params);
        return $target_uri->withQuery($merged_query);
    }
}
