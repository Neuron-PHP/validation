<?php

class CollectionTest extends PHPUnit\Framework\TestCase
{
	public $Collection;

	public function setUp() : void
	{
		parent::setUp();

		$this->Collection = new \Neuron\Validation\Collection();

		$this->Collection->add( 'Positive', new \Neuron\Validation\Positive() );
		$this->Collection->add( 'Int', new \Neuron\Validation\Integer() );

	}

	public function testFail()
	{
		$this->assertFalse( $this->Collection->isValid( -1 ) );
	}

	public function testFailList()
	{
		$this->Collection->isValid( 1.00 );

		$this->assertTrue(
			\Neuron\Data\ArrayHelper::contains( $this->Collection->getViolations(), 'Int' )
		);

		$this->Collection->isValid( -1 );

		$this->assertTrue(
			\Neuron\Data\ArrayHelper::contains( $this->Collection->getViolations(),'Positive' )
		);

		$this->Collection->isValid( -1.01 );

		$this->assertTrue(
			\Neuron\Data\ArrayHelper::contains( $this->Collection->getViolations(),'Positive' )
		);

		$this->assertTrue(
			\Neuron\Data\ArrayHelper::contains( $this->Collection->getViolations(),'Int' )
		);

	}


	public function testPass()
	{
		$this->assertTrue( $this->Collection->isValid( 1 ) );
	}
}
