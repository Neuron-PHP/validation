<?php
namespace Tests\Data\Validation;

use Neuron\Validation\DateRange;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
	public function testRangeFail()
	{
		$Validator = new DateRange();

		$Validator->setFormat( 'Y-m-d' );

		$this->assertFalse(
			$Validator->isValid(
				new \Neuron\Data\Object\DateRange( '2000-01-01', '2000-01-01' )
			)
		);
	}

	public function testRangePass()
	{
		$Validator = new DateRange();

		$Validator->setFormat( 'Y-m-d' );

		$this->assertTrue(
			$Validator->isValid(
				new \Neuron\Data\Object\DateRange( '2000-01-01', '2000-01-03' )
			)
		);
	}

}
