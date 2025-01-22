<?php
namespace Tests\Data\Validation;

use Neuron\Validation\IsStringLength;
use PHPUnit\Framework\TestCase;

class StringLengthTest extends TestCase
{
	public function testFail()
	{
		$Validator = new IsStringLength( 5, 10 );

		$this->assertFalse(
			$Validator->isValid( 'sssssssssss' )
		);

		$this->assertFalse(
			$Validator->isValid( 'ssss' )
		);

	}

	public function testPass()
	{
		$Validator = new IsStringLength( 3, 10 );

		$this->assertTrue(
			$Validator->isValid( 'test' )
		);
	}
}
