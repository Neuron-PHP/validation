<?php

namespace Data\Validation;

use Neuron\Validation\IsUpc;
use PHPUnit\Framework\TestCase;

class UpcTest extends TestCase
{
	public function testPass()
	{
		$Validator = new IsUpc();
		$this->assertTrue( $Validator->isValid( '123456789012' ) );
	}

	public function testFail()
	{
		$Validator = new IsUpc();
		$this->assertFalse( $Validator->isValid( '12345' ) );
	}
}
