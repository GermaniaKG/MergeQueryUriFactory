<?php
namespace tests;

use Germania\MergeQueryUriFactory\MergeQueryUriFactoryDecorator;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Prophecy\PhpUnit\ProphecyTrait;

class MergeQueryUriFactoryDecoratorTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    public function testInstantiation()
    {
        $uri_factory_mock = $this->prophesize(UriFactoryInterface::class);
        $uri_factory = $uri_factory_mock->reveal();

        $sut = new MergeQueryUriFactoryDecorator($uri_factory);
        $this->assertInstanceOf(UriFactoryInterface::class, $sut);
    }

    public function testDecoration()
    {
        $uri_factory = new Psr17Factory;
        $sut = new MergeQueryUriFactoryDecorator($uri_factory);

        $uri = $sut->createUri( 'http://httpbin.org' );
        $this->assertInstanceOf( UriInterface::class, $uri);

        return $sut;
    }


    /**
     * @dataProvider provideQueryParams
     * @depends testDecoration
     */
    public function testMergeQueryParams( array $merge_params, $expected_query, $sut )
    {
        $url = 'http://httpbin.org';

        $uri = $sut->createUriMergeQuery( $url, $merge_params);
        $this->assertInstanceOf( UriInterface::class, $uri);
        $this->assertEquals( $uri->getQuery(), $expected_query);
    }


    public function provideQueryParams()
    {
        return array(
            [ array('foo' => 'bar'), http_build_query(array('foo' => 'bar'))],
        );
    }
}
