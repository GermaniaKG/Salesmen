<?php
namespace tests;

use Germania\Salesmen\Salesman;
use Germania\Salesmen\SalesmanInterface;
use Germania\Salesmen\SalesmanIdProviderInterface;

class SalesmanTest extends \PHPUnit\Framework\TestCase
{
    public function testSimpleInstantiation()
    {
        $sut = new Salesman;
        $this->assertInstanceOf( SalesmanInterface::class, $sut );
        $this->assertInstanceOf( SalesmanIdProviderInterface::class, $sut );
    }

    public function testProperties()
    {
        $sut = new Salesman;

        $this->assertEmpty( $sut->getFullName() );
        $this->assertEmpty( $sut->getDisplayName() );
        $this->assertEmpty( $sut->__toString() );

        $first_name = "foo";
        $sut->first_name = $first_name;
        $this->assertEquals($sut->getFirstName(), $first_name);

        $last_name = "bar";
        $sut->last_name = $last_name;
        $this->assertEquals($sut->getLastName(), $last_name);

        $this->assertNotEmpty( $sut->getFullName() );
        $this->assertNotEmpty( $sut->getDisplayName() );

        $this->assertEquals( $sut->getDisplayName(), $sut->__toString() );

        $mail = "foo";
        $sut->email = $mail;
        $this->assertEquals($sut->getEmail(), $mail);

        $uid = 99;
        $sut->user_id = $uid;
        $this->assertEquals($sut->getUserId(), $uid);

        $active = true;
        $sut->is_active = $active;
        $this->assertEquals($sut->isActive(), $active);

    }

    public function testDebugInfo(  )
    {
        $sut = new Salesman;
        $debug_info = $sut->__debugInfo();
        $this->assertInternalType("array", $debug_info);
        
        $this->assertArrayHasKey('SalesmanID',  $debug_info);
        $this->assertArrayHasKey('FullName',    $debug_info);
        $this->assertArrayHasKey('Email',       $debug_info);
        $this->assertArrayHasKey('isActive',    $debug_info);
        $this->assertArrayHasKey('UserID',      $debug_info);
    }


}
