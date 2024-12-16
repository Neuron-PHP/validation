<?php
namespace Tests\Data\Validation;

class FloatTest extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$Validator = new \Neuron\Validation\FloatingPoint();

		$this->assertFalse( $Validator->isValid( 'string' ) );
	}

	public function testPass()
	{
		$Validator = new \Neuron\Validation\FloatingPoint();

		$this->assertTrue( $Validator->isValid( 3.14 ) );
	}

	public function testStringPass()
	{
		$Validator = new \Neuron\Validation\FloatingPoint();

		$this->assertTrue( $Validator->isValid( "3.14" ) );
	}
}
