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

    public function testInstantiation() : void
    {
        $uri_factory_mock = $this->prophesize(UriFactoryInterface::class);
        $uri_factory = $uri_factory_mock->reveal();

        $sut = new MergeQueryUriFactoryDecorator($uri_factory);
        $this->assertInstanceOf(UriFactoryInterface::class, $sut);
        $this->assertIsCallable( $sut );
    }

    public function testDecoration() : UriFactoryInterface
    {
        $uri_factory = new Psr17Factory;
        $sut = new MergeQueryUriFactoryDecorator($uri_factory);

        $uri = $sut->createUri( 'http://httpbin.org' );
        $this->assertInstanceOf( UriInterface::class, $uri);

        return $sut;
    }


    /**
     * @dataProvider provideInvalidArguments
     * @depends testDecoration
     */
    public function testInvalidArgumentException( $invalid, MergeQueryUriFactoryDecorator $sut ) : void
    {
        $this->expectException( \InvalidArgumentException::class );
        $sut->createUriMergeQuery( $invalid, array());
    }

    public function provideInvalidArguments()
    {
        return array(
            [ false ],
            [ true ],
            [ 8 ],
            [ new \StdClass() ]
        );
    }



    /**
     * @dataProvider provideQueryParams
     * @depends testDecoration
     */
    public function testMergeQueryParams( $uri,  array $merge_params, $expected_query, MergeQueryUriFactoryDecorator $sut ) : void
    {
        $uri = $sut->createUriMergeQuery( $uri, $merge_params);
        $this->assertInstanceOf( UriInterface::class, $uri);
        $this->assertEquals( $uri->getQuery(), $expected_query);

        // Test callable interface
        $uri2 = $sut( $uri, $merge_params);
        $this->assertInstanceOf( UriInterface::class, $uri2);
        $this->assertEquals( $uri2->getQuery(), $expected_query);

    }


    public function provideQueryParams() : array
    {
        $uri_string = 'http://httpbin.org';

        $uri_factory = new Psr17Factory;
        $uri_object = $uri_factory->createUri( $uri_string );

        return array(
            [ $uri_string, array('foo' => 'bar'), http_build_query(array('foo' => 'bar'))],
            [ $uri_object, array('foo' => 'bar'), http_build_query(array('foo' => 'bar'))],
        );
    }
}
