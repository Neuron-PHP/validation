<?php
namespace Tests\Data\Validation;

use Neuron\Validation\Collection;
use Neuron\Validation\Integer;
use Neuron\Validation\Positive;

class CollectionTest extends \PHPUnit\Framework\TestCase
{
	public Collection $Collection;

	public function setUp() : void
	{
		parent::setUp();

		$this->Collection = new Collection();

		$this->Collection->add( 'Positive', new Positive() );
		$this->Collection->add( 'Int', new Integer() );

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

	public function testGet()
	{
		$this->assertIsObject( $this->Collection->get( 'Positive' ) );
	}

	public function testRemove()
	{
		$this->assertFalse( $this->Collection->remove( 'Monkey' ) );

		$this->assertTrue( $this->Collection->remove( 'Positive' ) );

		$this->assertNull( $this->Collection->get( 'Positive' ) );
	}

}
