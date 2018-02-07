<?php
namespace tests;

use Germania\Salesmen\SalesmanProviderTrait;

class SalesmanProviderTraitTest extends \PHPUnit\Framework\TestCase
{
    public function testGetInterceptor()
    {
        $mock = $this->getMockForTrait(SalesmanProviderTrait::class);

        $salesman_id = 3;

        // Trait introduces this attribute
        $this->assertObjectHasAttribute('salesman_id', $mock);
        $mock->salesman_id = $salesman_id;

        $this->assertEquals( $salesman_id, $mock->getSalesmanId());
    }
}
