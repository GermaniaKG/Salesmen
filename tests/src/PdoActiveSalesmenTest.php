<?php
namespace tests;

use Germania\Salesmen\PdoActiveSalesmen;
use Germania\Salesmen\SalesmanInterface;
use Germania\Salesmen\Exceptions\SalesmanNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class PdoActiveSalesmenTest extends PdoAllSalesmenTest
{

    public function setUp()
    {
        $pdo = $this->getPdo();
        $this->sut = new PdoActiveSalesmen( $pdo, "salesmen");
    }

    public function testCountableInterface(  )
    {

        // We know this from "salesmen-dataset.xml"
        $rows = 1;

        $this->assertEquals( $rows, $this->sut->count());
        $this->assertEquals( $rows, iterator_count($this->sut));
    }



    public function testNotFoundException(  )
    {
        // We know this from "salesmen-dataset.xml",
        // that id 2 is marked inactive
        $this->expectException( NotFoundExceptionInterface::class );
        $this->expectException( SalesmanNotFoundException::class );
        $this->sut->get( 2 );
    }



}
