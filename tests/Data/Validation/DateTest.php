<?php
namespace Tests\Data\Validation;

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 9/5/15
 * IsTime: 11:07 AM
 */
class DateTest
	extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$dn = new \Neuron\Validation\IsDate();

		$dn->setFormat( 'Y-m-d' );

		$this->assertFalse( $dn->isValid( '01-01-2015' ) );
	}

	public function testPass()
	{
		$dn = new \Neuron\Validation\IsDate();

		$dn->setFormat( 'Y-m-d' );

		$this->assertTrue( $dn->isValid( '2015-01-01' ) );
	}
}
