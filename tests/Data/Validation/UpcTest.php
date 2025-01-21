<?php

namespace Data\Validation;

use Neuron\Validation\Upc;
use PHPUnit\Framework\TestCase;

class UpcTest extends TestCase
{
	public function testPass()
	{
		$Validator = new Upc();
		$this->assertTrue( $Validator->isValid( '123456789012' ) );
	}

	public function testFail()
	{
		$Validator = new Upc();
		$this->assertFalse( $Validator->isValid( '12345' ) );
	}
}
