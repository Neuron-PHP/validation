<?php
namespace Tests\Data\Validation;

use Neuron\Data\Objects\DateRange;
use Neuron\Validation\IsDateWithinRange;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 7/27/16
 * IsTime: 6:55 PM
 */
class DateWithinRangeTest extends TestCase
{

	public function testWithinRangeFail()
	{
		$Validator = new IsDateWithinRange( new DateRange( '2000-01-01', '2000-01-02') );

		$Validator->setFormat( 'Y-m-d' );

		$Range =  new DateRange( '2000-01-02', '2000-01-02');
		$Validator->setRange( $Range );

		$this->assertEquals( $Range, $Validator->getRange() );

		$this->assertFalse( $Validator->isValid( '2015-01-01' ) );
	}

	public function testWithinRangePass()
	{
		$Validator = new IsDateWithinRange( new DateRange( '2000-01-01', '2020-01-02' ) );

		$Validator->setFormat( 'Y-m-d' );

		$this->assertTrue( $Validator->isValid( '2015-01-01' ) );
	}

	public function testBadDateFormat()
	{
		$Validator = new IsDateWithinRange( new DateRange( '2000-01-01', '2020-01-02' ) );

		$Validator->setFormat( 'Y-m-d' );

		$this->assertFalse( $Validator->isValid( '201501' ) );
	}
}
