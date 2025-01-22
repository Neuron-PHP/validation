<?php

namespace Data\Validation;

use Neuron\Validation\IsRegExPattern;
use PHPUnit\Framework\TestCase;

class RegExPatternTest extends TestCase
{
	public function testRegExPattern()
	{
		$Pattern = new IsRegExPattern( '/^[a-zA-Z0-9]+$/' );

		$this->assertTrue( $Pattern->isValid( 'abc123' ) );
		$this->assertTrue( $Pattern->isValid( 'abc' ) );
		$this->assertTrue( $Pattern->isValid( '123' ) );
		$this->assertFalse( $Pattern->isValid( 'abc123!' ) );
	}

	public function testGetSet()
	{
		$Pattern = new IsRegExPattern( '/^[a-zA-Z0-9]+$/' );
		$Pattern->setPattern( '/^[a-zA-Z0-9]+$/' );
		$this->assertEquals( '/^[a-zA-Z0-9]+$/', $Pattern->getPattern() );
	}
}
