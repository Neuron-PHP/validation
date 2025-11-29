<?php
namespace Tests\Data\Validation;

use Neuron\Data\Objects\NumericRange;
use Neuron\Validation\IsNumberWithinRange;

class NumberWithinRangeTest extends \PHPUnit\Framework\TestCase
{
	public function testRangePass()
	{
		$Validator = new IsNumberWithinRange( new NumericRange( 1, 10 ) );

		$Range = new NumericRange( 1, 11 );
		$Validator->setRange( $Range );

		$this->assertEquals( $Range, $Validator->getRange() );

		$this->assertTrue(
			$Validator->isValid( 5 )
		);
	}

	public function testRangeFail()
	{
		$Validator = new IsNumberWithinRange( new NumericRange( 1, 10 ) );

		$this->assertFalse(
			$Validator->isValid( 11 )
		);
	}
}
