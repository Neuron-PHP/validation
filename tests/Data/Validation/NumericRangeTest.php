<?php
namespace Tests\Data\Validation;

class NumericRangeTest extends \PHPUnit\Framework\TestCase
{
	public function testRangePass()
	{
		$Validator = new \Neuron\Validation\IsNumericRange();

		$this->assertTrue(
			$Validator->isValid(
				new \Neuron\Data\Objects\NumericRange( 1, 10 )
			)
		);
	}

	public function testRangeFail()
	{
		$Validator = new \Neuron\Validation\IsNumericRange();

		$this->assertFalse(
			$Validator->isValid(
				new \Neuron\Data\Objects\NumericRange( 10, 1 )
			)
		);
	}

}
