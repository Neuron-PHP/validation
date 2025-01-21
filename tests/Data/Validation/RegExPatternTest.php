<?php

namespace Data\Validation;

use Neuron\Validation\RegExPattern;
use PHPUnit\Framework\TestCase;

class RegExPatternTest extends TestCase
{
	public function testRegExPattern()
	{
		$Pattern = new RegExPattern( '/^[a-zA-Z0-9]+$/' );

		$this->assertTrue( $Pattern->isValid( 'abc123' ) );
		$this->assertTrue( $Pattern->isValid( 'abc' ) );
		$this->assertTrue( $Pattern->isValid( '123' ) );
		$this->assertFalse( $Pattern->isValid( 'abc123!' ) );
	}
}
