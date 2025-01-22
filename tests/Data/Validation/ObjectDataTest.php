<?php

namespace Tests\Data\Validation;

use Neuron\Validation\IsObject;
use PHPUnit\Framework\TestCase;

class ObjectDataTest extends TestCase
{
	public function testFail()
	{
		$dn = new IsObject();

		$this->assertFalse( $dn->isValid( 1 ) );
	}

	public function testPass()
	{
		$dn = new IsObject();

		$this->assertTrue( $dn->isValid( new \stdClass() ) );
	}
}
