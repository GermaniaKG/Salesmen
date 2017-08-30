<?php
namespace tests;

use Germania\Salesmen\SalesmanInterceptorsTrait;
use Germania\Salesmen\SalesmanProviderInterface;

class SalesmanInterceptorsTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterAndSetter()
    {
        $mock = $this->getMockForTrait(SalesmanInterceptorsTrait::class);

        $salesman_id = 3;

        // Make sure we are really changing the number here
        $this->assertNotEquals( $salesman_id, $mock->getSalesmanId());

        $mock->setSalesmanId($salesman_id);
        $this->assertEquals( $salesman_id, $mock->getSalesmanId());
    }

    public function testSetterWithRetailerNumberProviderInterface()
    {
        $mock = $this->getMockForTrait(SalesmanInterceptorsTrait::class);

        // Make sure we are really changing the number here
        $salesman_id = 3;
        $this->assertNotEquals( $salesman_id, $mock->getSalesmanId());

        $provider = $this->prophesize( SalesmanProviderInterface::class );
        $provider->getSalesmanId()->willReturn( $salesman_id );
        $mock->setSalesmanId( $provider->reveal() );

        $this->assertEquals( $salesman_id, $mock->getSalesmanId());
    }
}
