<?php
namespace Tests\Data\Validation;

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 9/5/15
 * IsTime: 11:07 AM
 */

class EmailTest
	extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$dn = new \Neuron\Validation\IsEmail();

		$this->assertFalse( $dn->isValid( 'test_example.org' ) );
	}

	public function testPass()
	{
		$dn = new \Neuron\Validation\IsEmail();

		$this->assertTrue( $dn->isValid( 'test@example.org' ) );
	}

}
