<?php
namespace Tests\Data\Validation;

use Neuron\Validation\IsTime;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: jeremiahyoder
 * Date: 2/22/17
 * IsTime: 9:16 AM
 */

class TimeTest extends TestCase
{
	public function testFail()
	{
		$dn = new IsTime();

		$dn->setFormat( 'g:i:s A' );

		$this->assertFalse( $dn->isValid( '1:30' ) );
	}

	public function testPass()
	{
		$dn = new IsTime();

		$dn->setFormat( 'g:i:s A' );

		$this->assertTrue( $dn->isValid( '1:30:23 PM' ) );
	}

	public function testGetSet()
	{
		$dn = new IsTime();
		$dn->setFormat( 'g:i:s A' );
		$this->assertEquals( 'g:i:s A', $dn->getFormat() );
	}
}
