<?php
namespace Tests\Data\Validation;

use Neuron\Validation\Collection;
use Neuron\Validation\IsInteger;
use Neuron\Validation\IsPositive;

class CollectionTest extends \PHPUnit\Framework\TestCase
{
	public Collection $Collection;

	public function setUp() : void
	{
		parent::setUp();

		$this->Collection = new Collection();

		$this->Collection->add( 'IsPositive', new IsPositive() );
		$this->Collection->add( 'Int', new IsInteger() );

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
			\Neuron\Data\ArrayHelper::contains( $this->Collection->getViolations(),'IsPositive' )
		);

		$this->Collection->isValid( -1.01 );

		$this->assertTrue(
			\Neuron\Data\ArrayHelper::contains( $this->Collection->getViolations(),'IsPositive' )
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
		$this->assertIsObject( $this->Collection->get( 'IsPositive' ) );
	}

	public function testRemove()
	{
		$Collection = new Collection();

		$this->assertFalse( $Collection->remove( 'Monkey' ) );

		$this->assertTrue( $this->Collection->remove( 'IsPositive' ) );

		$this->assertNull( $this->Collection->get( 'IsPositive' ) );
	}

}
