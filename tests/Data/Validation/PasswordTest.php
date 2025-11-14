<?php
namespace Tests\Data\Validation;

use Neuron\Validation\IsPassword;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
	public function testMinimumLength()
	{
		$validator = new IsPassword( 8 );

		// Should fail - too short
		$this->assertFalse( $validator->isValid( 'pass' ) );
		$this->assertFalse( $validator->isValid( 'pass123' ) );

		// Should pass - meets minimum
		$this->assertTrue( $validator->isValid( 'password' ) );
		$this->assertTrue( $validator->isValid( 'password123' ) );
	}

	public function testMaximumLength()
	{
		$validator = new IsPassword( 8, 12 );

		// Should fail - too long
		$this->assertFalse( $validator->isValid( 'thisisaverylongpassword' ) );

		// Should pass - within range
		$this->assertTrue( $validator->isValid( 'password' ) );
		$this->assertTrue( $validator->isValid( 'password12' ) );
	}

	public function testRequireUppercase()
	{
		$validator = new IsPassword( 8, null, true );

		// Should fail - no uppercase
		$this->assertFalse( $validator->isValid( 'password' ) );
		$this->assertFalse( $validator->isValid( 'password123' ) );

		// Should pass - has uppercase
		$this->assertTrue( $validator->isValid( 'Password' ) );
		$this->assertTrue( $validator->isValid( 'PASSWORD123' ) );
		$this->assertTrue( $validator->isValid( 'pAssword' ) );
	}

	public function testRequireLowercase()
	{
		$validator = new IsPassword( 8, null, false, true );

		// Should fail - no lowercase
		$this->assertFalse( $validator->isValid( 'PASSWORD' ) );
		$this->assertFalse( $validator->isValid( 'PASSWORD123' ) );

		// Should pass - has lowercase
		$this->assertTrue( $validator->isValid( 'Password' ) );
		$this->assertTrue( $validator->isValid( 'password123' ) );
		$this->assertTrue( $validator->isValid( 'PASSWORDa' ) );
	}

	public function testRequireDigit()
	{
		$validator = new IsPassword( 8, null, false, false, true );

		// Should fail - no digit
		$this->assertFalse( $validator->isValid( 'password' ) );
		$this->assertFalse( $validator->isValid( 'PASSWORD' ) );

		// Should pass - has digit
		$this->assertTrue( $validator->isValid( 'password1' ) );
		$this->assertTrue( $validator->isValid( 'PASSWORD123' ) );
		$this->assertTrue( $validator->isValid( '12345678' ) );
	}

	public function testRequireSpecial()
	{
		$validator = new IsPassword( 8, null, false, false, false, true );

		// Should fail - no special character
		$this->assertFalse( $validator->isValid( 'password' ) );
		$this->assertFalse( $validator->isValid( 'password123' ) );

		// Should pass - has special character
		$this->assertTrue( $validator->isValid( 'password!' ) );
		$this->assertTrue( $validator->isValid( 'pass@word' ) );
		$this->assertTrue( $validator->isValid( 'p#ssw0rd' ) );
	}

	public function testComplexPassword()
	{
		// Require all: 12 chars min, 64 max, upper, lower, digit, special
		$validator = new IsPassword( 12, 64, true, true, true, true );

		// Should fail - various reasons
		$this->assertFalse( $validator->isValid( 'short' ) ); // too short
		$this->assertFalse( $validator->isValid( 'password123' ) ); // no uppercase, no special
		$this->assertFalse( $validator->isValid( 'PASSWORD123!' ) ); // no lowercase
		$this->assertFalse( $validator->isValid( 'Password!' ) ); // no digit
		$this->assertFalse( $validator->isValid( 'Password123' ) ); // no special

		// Should pass - meets all requirements
		$this->assertTrue( $validator->isValid( 'MyP@ssw0rd123' ) );
		$this->assertTrue( $validator->isValid( 'Str0ng!Password' ) );
		$this->assertTrue( $validator->isValid( 'C0mpl3x#Pass' ) );
	}

	public function testCustomSpecialChars()
	{
		// Only allow @ and # as special characters
		$validator = new IsPassword( 8, null, false, false, false, true, '@#' );

		// Should fail - special char not in allowed set
		$this->assertFalse( $validator->isValid( 'password!' ) );
		$this->assertFalse( $validator->isValid( 'pass$word' ) );

		// Should pass - uses allowed special chars
		$this->assertTrue( $validator->isValid( 'password@' ) );
		$this->assertTrue( $validator->isValid( 'pass#word' ) );
		$this->assertTrue( $validator->isValid( 'p@ssw#rd' ) );
	}

	public function testNonStringValue()
	{
		$validator = new IsPassword( 8 );

		// Should fail - not a string
		$this->assertFalse( $validator->isValid( 12345678 ) );
		$this->assertFalse( $validator->isValid( null ) );
		$this->assertFalse( $validator->isValid( [] ) );
		$this->assertFalse( $validator->isValid( true ) );
	}

	public function testNoMaximumLength()
	{
		$validator = new IsPassword( 8, null );

		// Should pass - no maximum length restriction
		$this->assertTrue( $validator->isValid( 'password' ) );
		$this->assertTrue( $validator->isValid( 'thisisaverylongpasswordthatgoesonfar' ) );
		$this->assertTrue( $validator->isValid( str_repeat( 'a', 1000 ) ) );
	}

	public function testEmptyPassword()
	{
		$validator = new IsPassword( 1 );

		// Should fail - empty string
		$this->assertFalse( $validator->isValid( '' ) );
	}

	public function testEdgeCases()
	{
		// Test exact length boundaries
		$validator = new IsPassword( 8, 10 );

		// Exactly minimum length
		$this->assertTrue( $validator->isValid( 'password' ) ); // 8 chars

		// Exactly maximum length
		$this->assertTrue( $validator->isValid( 'password12' ) ); // 10 chars

		// Just under minimum
		$this->assertFalse( $validator->isValid( 'passwor' ) ); // 7 chars

		// Just over maximum
		$this->assertFalse( $validator->isValid( 'password123' ) ); // 11 chars
	}

	public function testSpecialCharsEscaping()
	{
		// Test with special regex characters that need escaping
		$validator = new IsPassword( 8, null, false, false, false, true, '[]{}()^$.*+?|\\' );

		// Should pass - uses special regex chars properly escaped
		$this->assertTrue( $validator->isValid( 'password[' ) );
		$this->assertTrue( $validator->isValid( 'pass]word' ) );
		$this->assertTrue( $validator->isValid( 'pass{word' ) );
		$this->assertTrue( $validator->isValid( 'pass}word' ) );
		$this->assertTrue( $validator->isValid( 'pass(word' ) );
		$this->assertTrue( $validator->isValid( 'pass)word' ) );
		$this->assertTrue( $validator->isValid( 'pass^word' ) );
		$this->assertTrue( $validator->isValid( 'pass$word' ) );
		$this->assertTrue( $validator->isValid( 'pass.word' ) );
		$this->assertTrue( $validator->isValid( 'pass*word' ) );
		$this->assertTrue( $validator->isValid( 'pass+word' ) );
		$this->assertTrue( $validator->isValid( 'pass?word' ) );
		$this->assertTrue( $validator->isValid( 'pass|word' ) );
		$this->assertTrue( $validator->isValid( 'pass\\word' ) );
	}
}
