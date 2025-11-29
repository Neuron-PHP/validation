<?php
namespace Tests\Data\Validation;

use Neuron\Validation\IsDateRange;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
	public function testRangeFail()
	{
		$Validator = new IsDateRange();

		$Validator->setFormat( 'Y-m-d' );

		$this->assertFalse(
			$Validator->isValid(
				new \Neuron\Data\Objects\DateRange( '2000-01-01', '2000-01-01' )
			)
		);
	}

	public function testRangePass()
	{
		$Validator = new IsDateRange();

		$Validator->setFormat( 'Y-m-d' );

		$this->assertTrue(
			$Validator->isValid(
				new \Neuron\Data\Objects\DateRange( '2000-01-01', '2000-01-03' )
			)
		);
	}

}
