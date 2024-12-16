<?php
namespace Tests\Data\Validation;

/**
 * Created by PhpStorm.
 * User: jeremiahyoder
 * Date: 2/22/17
 * Time: 9:16 AM
 */

class TimeTest extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$dn = new \Neuron\Validation\Time();

		$dn->setFormat( 'g:i:s A' );

		$this->assertFalse( $dn->isValid( '1:30' ) );
	}

	public function testPass()
	{
		$dn = new \Neuron\Validation\Time();

		$dn->setFormat( 'g:i:s A' );

		$this->assertTrue( $dn->isValid( '1:30:23 PM' ) );
	}
}
