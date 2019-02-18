<?php
namespace tests;

use Germania\Salesmen\PdoAllSalesmen;
use Germania\Salesmen\SalesmanInterface;
use Germania\Salesmen\SalesmanIdProviderInterface;
use Germania\Salesmen\Exceptions\SalesmanNotFoundException;
use Germania\Salesmen\Exceptions\SalesmanDatabaseException;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class PdoAllSalesmenTest extends DatabaseTestCaseAbstract
{
    use MockPdoTrait;


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

    public function testDebugInfo(  )
    {
        $debug_info = $this->sut->__debugInfo();
        $this->assertInternalType("array", $debug_info);
        
        $this->assertArrayHasKey('DatabaseTable',    $debug_info);
        $this->assertArrayHasKey('NumberOfSalesmen', $debug_info);
        $this->assertArrayHasKey('SalesmanClass',    $debug_info);
    }


    public function testExceptionOnExecutionError(  )
    {
        $execution_result = false;
        $stmt_mock = $this->createMockPdoStatement( $execution_result, array() );
        $pdo_mock = $this->createMockPdo( $stmt_mock );
        $this->expectException( SalesmanDatabaseException::class );
        $sut = new PdoAllSalesmen( $pdo_mock, "salesmen");

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


    /**
     * @dataProvider provideSalesmanIdOrProvider
     */
    public function testContainerInterface( $salesman_id )
    {
        $this->assertTrue( $this->sut->has( $salesman_id ));
        $this->assertInstanceOf( SalesmanInterface::class, $this->sut->get( $salesman_id ) );
    }

    public function provideSalesmanIdOrProvider()
    {
        // We know this from "salesmen-dataset.xml"
        $salesman_id = 1;

        $mock = $this->prophesize( SalesmanIdProviderInterface::class );
        $mock->getSalesmanId()->willReturn( $salesman_id );
        $salesman_id_provider = $mock->reveal();

        return array(
            [ $salesman_id ],
            [ $salesman_id_provider]
        );
    }




    public function testNotFoundException(  )
    {
        // We know this from "salesmen-dataset.xml"
        $this->expectException( NotFoundExceptionInterface::class );
        $this->expectException( SalesmanNotFoundException::class );
        $this->sut->get( 22 );
    }



}
