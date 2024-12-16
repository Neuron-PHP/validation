<?php
namespace Tests\Data\Validation;

class CurrencyTest extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$Currency = new \Neuron\Validation\Currency();

		$this->assertFalse( $Currency->isValid( '3x' ) );
	}

	public function testPass()
	{
		$Currency = new \Neuron\Validation\Currency();

		$this->assertTrue( $Currency->isValid( '1.01' ) );
	}
}
