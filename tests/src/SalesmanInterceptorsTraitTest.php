<?php
namespace tests;

use Germania\Salesmen\SalesmanIdAwareTrait;
use Germania\Salesmen\SalesmanIdProviderInterface;

class SalesmanInterceptorsTraitTest extends \PHPUnit\Framework\TestCase
{
    public function testGetterAndSetter()
    {
        $mock = $this->getMockForTrait(SalesmanIdAwareTrait::class);

        $salesman_id = 3;

        // Make sure we are really changing the number here
        $this->assertNotEquals( $salesman_id, $mock->getSalesmanId());

        $mock->setSalesmanId($salesman_id);
        $this->assertEquals( $salesman_id, $mock->getSalesmanId());
    }


    public function testSetterWithRetailerNumberProviderInterface()
    {
        $mock = $this->getMockForTrait(SalesmanIdAwareTrait::class);

        // Make sure we are really changing the number here
        $salesman_id = 3;
        $this->assertNotEquals( $salesman_id, $mock->getSalesmanId());

        $provider = $this->prophesize( SalesmanIdProviderInterface::class );
        $provider->getSalesmanId()->willReturn( $salesman_id );
        $mock->setSalesmanId( $provider->reveal() );

        $this->assertEquals( $salesman_id, $mock->getSalesmanId());
    }
}
