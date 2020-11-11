<?php
namespace Germania\MergeQueryUriFactory;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * This UriFactory decorator builds an UriInterface
 * from an URI string or UriInterface and an Query String Parameters array.
 *
 * The `createUriMergeQuery` method accepts an array with additional query params
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


    public function __invoke( $url, array $query_params = array() ) : UriInterface
    {
        return $this->createUriMergeQuery( $url, $query_params );
    }


    /**
     * @param  string|UriInterface  $url   URI string or UriInterface
     * @param  array  $query_params        Overriding query parameters
     * @return UriInterface                New URI
     */
    public function createUriMergeQuery( $url, array $query_params = array() ) : UriInterface
    {
        if (is_string($url)) {
            $target_uri = $this->createUri($url);
        }
        elseif ($url instanceOf UriInterface) {
            $target_uri = $url;
        }
        else {
            throw new \InvalidArgumentException("Expected UriInterface or string.");
        }


        // Merge redirect params into original parameters
        parse_str($target_uri->getQuery(), $target_params);
        $merged_params = array_merge($target_params, $query_params);

        $merged_query = http_build_query($merged_params);
        return $target_uri->withQuery($merged_query);
    }
}
