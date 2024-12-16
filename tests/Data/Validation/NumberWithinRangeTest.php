<?php
namespace Tests\Data\Validation;

class NumberWithinRangeTest extends \PHPUnit\Framework\TestCase
{
	public function testRangePass()
	{
		$Validator = new \Neuron\Validation\NumberWithinRange();

		$Validator->setRange(
			new \Neuron\Data\Object\NumericRange( 1, 10 )
		);

		$this->assertTrue(
			$Validator->isValid( 5 )
		);
	}

	public function testRangeFail()
	{
		$Validator = new \Neuron\Validation\NumberWithinRange();

		$Validator->setRange(
			new \Neuron\Data\Object\NumericRange( 1, 10 )
		);

		$this->assertFalse(
			$Validator->isValid( 11 )
		);
	}
}
