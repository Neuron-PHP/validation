<?php
namespace Tests\Data\Validation;

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 9/5/15
 * IsTime: 11:07 AM
 */

class IPAddressTest
	extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$dn = new \Neuron\Validation\IsIpAddress();

		$this->assertFalse( $dn->isValid( 'example.org' ) );
	}

	public function testPass()
	{
		$dn = new \Neuron\Validation\IsIpAddress();

		$this->assertTrue( $dn->isValid( '192.168.1.1' ) );
	}

}
