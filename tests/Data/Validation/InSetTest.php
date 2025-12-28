<?php
namespace Tests\Data\Validation;

use Neuron\Validation\IsInSet;
use PHPUnit\Framework\TestCase;

class InSetTest extends TestCase
{
	public function testPassWithStringInSet()
	{
		$validator = new IsInSet( ['admin', 'editor', 'author', 'subscriber'] );

		$this->assertTrue( $validator->isValid( 'admin' ) );
		$this->assertTrue( $validator->isValid( 'editor' ) );
		$this->assertTrue( $validator->isValid( 'author' ) );
		$this->assertTrue( $validator->isValid( 'subscriber' ) );
	}

	public function testFailWithStringNotInSet()
	{
		$validator = new IsInSet( ['admin', 'editor', 'author'] );

		$this->assertFalse( $validator->isValid( 'moderator' ) );
		$this->assertFalse( $validator->isValid( 'superadmin' ) );
		$this->assertFalse( $validator->isValid( '' ) );
	}

	public function testStrictComparisonCaseSensitive()
	{
		$validator = new IsInSet( ['admin', 'editor'] );

		$this->assertTrue( $validator->isValid( 'admin' ) );
		$this->assertFalse( $validator->isValid( 'ADMIN' ) );
		$this->assertFalse( $validator->isValid( 'Admin' ) );
	}

	public function testStrictComparisonTypeCheck()
	{
		$validator = new IsInSet( [1, 2, 3], true );

		$this->assertTrue( $validator->isValid( 1 ) );
		$this->assertTrue( $validator->isValid( 2 ) );
		$this->assertFalse( $validator->isValid( '1' ) ); // String vs int
		$this->assertFalse( $validator->isValid( '2' ) );
	}

	public function testLooseComparison()
	{
		$validator = new IsInSet( [1, 2, 3], false );

		$this->assertTrue( $validator->isValid( 1 ) );
		$this->assertTrue( $validator->isValid( '1' ) ); // Loose comparison allows this
		$this->assertTrue( $validator->isValid( '2' ) );
		$this->assertTrue( $validator->isValid( 3 ) );
		$this->assertFalse( $validator->isValid( 4 ) );
		$this->assertFalse( $validator->isValid( '5' ) );
	}

	public function testEmptySet()
	{
		$validator = new IsInSet( [] );

		$this->assertFalse( $validator->isValid( 'anything' ) );
		$this->assertFalse( $validator->isValid( 1 ) );
		$this->assertFalse( $validator->isValid( null ) );
	}

	public function testMixedTypes()
	{
		$validator = new IsInSet( ['active', 1, true, null], true );

		$this->assertTrue( $validator->isValid( 'active' ) );
		$this->assertTrue( $validator->isValid( 1 ) );
		$this->assertTrue( $validator->isValid( true ) );
		$this->assertTrue( $validator->isValid( null ) );

		$this->assertFalse( $validator->isValid( 'inactive' ) );
		$this->assertFalse( $validator->isValid( 2 ) );
		$this->assertFalse( $validator->isValid( false ) );
	}

	public function testGetAllowedValues()
	{
		$allowedValues = ['red', 'green', 'blue'];
		$validator = new IsInSet( $allowedValues );

		$this->assertEquals( $allowedValues, $validator->getAllowedValues() );
	}

	public function testSetAllowedValues()
	{
		$validator = new IsInSet( ['old'] );

		$newValues = ['new1', 'new2', 'new3'];
		$validator->setAllowedValues( $newValues );

		$this->assertEquals( $newValues, $validator->getAllowedValues() );
		$this->assertTrue( $validator->isValid( 'new1' ) );
		$this->assertFalse( $validator->isValid( 'old' ) );
	}

	public function testIsStrict()
	{
		$strictValidator = new IsInSet( [1, 2, 3], true );
		$looseValidator = new IsInSet( [1, 2, 3], false );

		$this->assertTrue( $strictValidator->isStrict() );
		$this->assertFalse( $looseValidator->isStrict() );
	}

	public function testSetStrict()
	{
		$validator = new IsInSet( [1, 2, 3], true );

		$this->assertTrue( $validator->isStrict() );
		$this->assertFalse( $validator->isValid( '1' ) );

		$validator->setStrict( false );

		$this->assertFalse( $validator->isStrict() );
		$this->assertTrue( $validator->isValid( '1' ) );
	}

	public function testNullValue()
	{
		$validator = new IsInSet( ['a', 'b', null] );

		$this->assertTrue( $validator->isValid( null ) );
	}

	public function testBooleanValues()
	{
		$validator = new IsInSet( [true, false] );

		$this->assertTrue( $validator->isValid( true ) );
		$this->assertTrue( $validator->isValid( false ) );
		$this->assertFalse( $validator->isValid( 1 ) ); // Strict: 1 !== true
		$this->assertFalse( $validator->isValid( 0 ) ); // Strict: 0 !== false
	}

	public function testNumericStrings()
	{
		$validator = new IsInSet( ['1', '2', '3'], true );

		$this->assertTrue( $validator->isValid( '1' ) );
		$this->assertFalse( $validator->isValid( 1 ) ); // Strict comparison
	}
}
