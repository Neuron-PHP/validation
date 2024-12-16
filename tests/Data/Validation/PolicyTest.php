<?php
namespace Tests\Data\Validation;

class PolicyTest extends \PHPUnit\Framework\TestCase
{
	private $PolicyTraitObj;

	public function setUp() : void
	{
		$this->PolicyTraitObj = $this->getObjectForTrait( '\Neuron\Validation\Policy' );

		$DateRange = new \Neuron\Validation\DateWithinRange();

		$DateRange->setFormat( 'Y-m-d' )
			->setRange( new \Neuron\Data\Object\DateRange( '2000-01-01', '2020-01-02') );

		$this->PolicyTraitObj->addRule(
			'DateRule',
			$DateRange
		);

		$PositiveCurrency = new \Neuron\Validation\Collection();

		$PositiveCurrency->add( 'Positive', new \Neuron\Validation\Positive() );
		$PositiveCurrency->add( 'Currency', new \Neuron\Validation\Currency() );

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
