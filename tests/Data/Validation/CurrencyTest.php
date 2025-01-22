<?php
namespace Tests\Data\Validation;

use Neuron\Validation\IsCurrency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
	public function testFail()
	{
		$Currency = new IsCurrency();

		$this->assertFalse( $Currency->isValid( '3x' ) );
	}

	public function testPass()
	{
		$Currency = new IsCurrency();

		$this->assertTrue( $Currency->isValid( '1.01' ) );
	}
}
