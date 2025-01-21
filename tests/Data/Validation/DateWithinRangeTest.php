<?php
namespace Tests\Data\Validation;

use Neuron\Data\Object\DateRange;
use Neuron\Validation\DateWithinRange;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 7/27/16
 * Time: 6:55 PM
 */
class DateWithinRangeTest extends TestCase
{

	public function testWithinRangeFail()
	{
		$Validator = new DateWithinRange();

		$Validator->setFormat( 'Y-m-d' );
		$Validator->setRange( new DateRange( '2000-01-01', '2000-01-02') );

		$this->assertFalse( $Validator->isValid( '2015-01-01' ) );
	}

	public function testWithinRangePass()
	{
		$Validator = new DateWithinRange();

		$Validator->setFormat( 'Y-m-d' );
		$Validator->setRange( new DateRange( '2000-01-01', '2020-01-02' ) );

		$this->assertTrue( $Validator->isValid( '2015-01-01' ) );
	}

	public function testBadDateFormat()
	{
		$Validator = new DateWithinRange();

		$Validator->setFormat( 'Y-m-d' );
		$Validator->setRange( new DateRange( '2000-01-01', '2020-01-02' ) );

		$this->assertFalse( $Validator->isValid( '201501' ) );
	}
}
