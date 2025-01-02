<?php

namespace Tests\Data\Validation;

use Neuron\Validation\ObjectData;
use PHPUnit\Framework\TestCase;

class ObjectDataTest extends TestCase
{
	public function testFail()
	{
		$dn = new ObjectData();

		$this->assertFalse( $dn->isValid( 1 ) );
	}

	public function testPass()
	{
		$dn = new ObjectData();

		$this->assertTrue( $dn->isValid( new \stdClass() ) );
	}
}
