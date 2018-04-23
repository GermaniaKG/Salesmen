<?php
namespace tests;

use Germania\Salesmen\PdoAllSalesmen;
use Germania\Salesmen\SalesmanInterface;
use Germania\Salesmen\Exceptions\SalesmanNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class PdoAllSalesmenTest extends DatabaseTestCaseAbstract
{

    public $sut;

    public function setUp()
    {
        $pdo = $this->getPdo();
        $this->sut = new PdoAllSalesmen( $pdo, "salesmen");
    }

    public function testInstantiation(  )
    {

        $this->assertInstanceOf( ContainerInterface::class, $this->sut);
        $this->assertInstanceOf( \Countable::class, $this->sut);
        $this->assertInternalType("array", $this->sut->salesmen);
    }


    public function testTraversableInterface(  )
    {
        $this->assertInstanceOf( \Traversable::class, $this->sut);
        $this->assertInstanceOf( \Iterator::class, $this->sut->getIterator());
    }


    public function testCountableInterface(  )
    {
        // We know this from "salesmen-dataset.xml"
        $rows = 3;
        $this->assertEquals( $rows, count($this->sut) );
        $this->assertEquals( $rows, $this->sut->count() );
        $this->assertEquals( $rows, iterator_count($this->sut) );
    }



    public function testContainerInterface(  )
    {
        // We know this from "salesmen-dataset.xml"
        $salesman_id = 1;
        $this->assertTrue( $this->sut->has( $salesman_id ));
        $this->assertInstanceOf( SalesmanInterface::class, $this->sut->get( $salesman_id ) );
    }


    public function testNotFoundException(  )
    {
        // We know this from "salesmen-dataset.xml"
        $this->expectException( NotFoundExceptionInterface::class );
        $this->expectException( SalesmanNotFoundException::class );
        $this->sut->get( 22 );
    }



}
