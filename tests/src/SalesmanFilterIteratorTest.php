<?php
namespace tests;

use Germania\Salesmen\SalesmanFilterIterator;
use Germania\Salesmen\SalesmanProviderInterface;


class SalesmanFilterIteratorTest extends \PHPUnit_Framework_TestCase
{

    public $collection;

    public function setUp()
    {
        $provider1 = $this->prophesize( SalesmanProviderInterface::class );
        $provider1->getSalesmanId()->willReturn( 1 );

        $provider2 = $this->prophesize( SalesmanProviderInterface::class );
        $provider2->getSalesmanId()->willReturn( 2 );

        $provider3 = $this->prophesize( SalesmanProviderInterface::class );
        $provider3->getSalesmanId()->willReturn( array(2, "3") );

        $this->collection = new \ArrayIterator([
            $provider1->reveal(),
            $provider2->reveal(),
            $provider3->reveal()
        ]);
    }



    /**
     * @dataProvider provideFilterValuesAndResults
     */
    public function testValuesAndResultCount( $filter_value, $result_count )
    {
        $sut = new SalesmanFilterIterator($this->collection, $filter_value);

        $this->assertEquals($result_count, iterator_count($sut));
    }



    public function provideFilterValuesAndResults()
    {

        $parameter_sets = array();
        return array(
            [ 1,              1 ],
            [ 2,              2 ],
            [ "2",            2 ],
            [ array(2,"3"),   2 ],
            [ array("2",3),   2 ],
            [ array(3),       1 ],
            [ array("3"),     1 ],


            [ 99,             0 ],
            [ "24",           0 ],
            [ 32.0,           0 ],
            [ 0,              0 ],
            [ array(),        0 ],
            [ array(0),       0 ],
            [ array(66,55),   0 ],
            [ null,           0 ],
        );

    }

}
