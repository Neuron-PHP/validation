<?php
namespace Tests\Data\Validation;

use Neuron\Data\Objects\DateRange;
use Neuron\Validation\Collection;
use Neuron\Validation\IsDateWithinRange;
use Neuron\Validation\IsPositive;

class PolicyTest extends \PHPUnit\Framework\TestCase
{
	private $PolicyTraitObj;

	public function setUp() : void
	{
		$this->PolicyTraitObj = $this->getObjectForTrait( '\Neuron\Validation\Policy' );

		$DateRange = new IsDateWithinRange( new DateRange( '2000-01-01', '2020-01-02') );

		$DateRange->setFormat( 'Y-m-d' );

		$this->PolicyTraitObj->addRule(
			'DateRule',
			$DateRange
		);

		$PositiveCurrency = new Collection();

		$PositiveCurrency->add( 'IsPositive', new IsPositive() );
		$PositiveCurrency->add( 'IsCurrency', new \Neuron\Validation\IsCurrency() );

		$this->PolicyTraitObj->addRule( 'PositiveCurrency', $PositiveCurrency );
	}

	public function testDateRange()
	{
		$this->assertFalse(
			$this->PolicyTraitObj->isRuleValid( 'DateRule', '1970-04-08' )
		);
		$this->assertTrue(
			$this->PolicyTraitObj->isRuleValid( 'DateRule', '2001-01-01' )
		);
	}

	public function testCurrency()
	{
		$this->assertFalse(
			$this->PolicyTraitObj->isRuleValid( 'PositiveCurrency', 'meh' )
		);

		$this->assertFalse(
			$this->PolicyTraitObj->isRuleValid( 'PositiveCurrency', -1 )
		);

		$this->assertTrue(
			$this->PolicyTraitObj->isRuleValid( 'PositiveCurrency', '1.00' )
		);

	}
}
