<?php

namespace Tests\Data\Validation;

use Neuron\Validation\IsBase64;
use PHPUnit\Framework\TestCase;

class Base64Test extends TestCase
{
	public function testValidStandardBase64()
	{
		$validator = new IsBase64();

		// Simple encoded text
		$this->assertTrue( $validator->isValid( base64_encode( 'Hello World' ) ) );
		$this->assertTrue( $validator->isValid( 'SGVsbG8gV29ybGQ=' ) );

		// Encoded JSON
		$json = json_encode( [ 'name' => 'test', 'value' => 123 ] );
		$this->assertTrue( $validator->isValid( base64_encode( $json ) ) );

		// Different padding scenarios
		$this->assertTrue( $validator->isValid( 'YQ==' ) ); // 'a' with double padding
		$this->assertTrue( $validator->isValid( 'YWI=' ) ); // 'ab' with single padding
		$this->assertTrue( $validator->isValid( 'YWJj' ) ); // 'abc' with no padding

		// Longer encoded string
		$longText = str_repeat( 'The quick brown fox jumps over the lazy dog. ', 10 );
		$this->assertTrue( $validator->isValid( base64_encode( $longText ) ) );
	}

	public function testValidUrlSafeBase64()
	{
		$validator = new IsBase64( true );

		// URL-safe base64 uses - and _ instead of + and /
		$this->assertTrue( $validator->isValid( 'SGVsbG8gV29ybGQ=' ) );
		$this->assertTrue( $validator->isValid( 'PDw_Pz8-Pg==' ) ); // Contains URL-safe chars

		// Standard base64 with + and / should also work
		$binaryData = "\x00\xFF\xFE\xFD\xFC";
		$this->assertTrue( $validator->isValid( base64_encode( $binaryData ) ) );
	}

	public function testStrictUrlSafeMode()
	{
		$validator = new IsBase64( false );

		// Standard base64 should work
		$this->assertTrue( $validator->isValid( base64_encode( 'test' ) ) );

		// URL-safe variant should also work (converted internally)
		$this->assertTrue( $validator->isValid( 'SGVsbG8gV29ybGQ=' ) );
	}

	public function testInvalidBase64()
	{
		$validator = new IsBase64();

		// Invalid characters
		$this->assertFalse( $validator->isValid( 'Invalid!Base64@String#' ) );
		$this->assertFalse( $validator->isValid( 'SGVsbG8gV29ybGQ' ) ); // Missing padding
		$this->assertFalse( $validator->isValid( 'Hello World' ) ); // Plain text
		$this->assertFalse( $validator->isValid( '!!!!' ) );
		$this->assertFalse( $validator->isValid( '====' ) ); // Only padding

		// Malformed padding
		$this->assertFalse( $validator->isValid( 'YQ=' ) ); // Wrong padding
		$this->assertFalse( $validator->isValid( 'YWJj=' ) ); // Unnecessary padding
	}

	public function testEmptyString()
	{
		$validator = new IsBase64();

		$this->assertFalse( $validator->isValid( '' ) );
	}

	public function testNonStringTypes()
	{
		$validator = new IsBase64();

		// Integers
		$this->assertFalse( $validator->isValid( 123 ) );
		$this->assertFalse( $validator->isValid( 0 ) );

		// Null
		$this->assertFalse( $validator->isValid( null ) );

		// Boolean
		$this->assertFalse( $validator->isValid( true ) );
		$this->assertFalse( $validator->isValid( false ) );

		// Array
		$this->assertFalse( $validator->isValid( [] ) );
		$this->assertFalse( $validator->isValid( [ 'test' ] ) );

		// Object
		$this->assertFalse( $validator->isValid( new \stdClass() ) );
	}

	public function testBase64WithWhitespace()
	{
		$validator = new IsBase64();

		// Base64 with whitespace (should be valid after stripping)
		$this->assertTrue( $validator->isValid( "SGVs\nbG8g\nV29y\nbGQ=" ) ); // With newlines
		$this->assertTrue( $validator->isValid( "SGVs bG8g V29y bGQ=" ) ); // With spaces
		$this->assertTrue( $validator->isValid( "\tSGVsbG8gV29ybGQ=\t" ) ); // With tabs
	}

	public function testRealWorldExamples()
	{
		$validator = new IsBase64();

		// Small image data URI (1x1 transparent PNG)
		$pngData = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
		$this->assertTrue( $validator->isValid( $pngData ) );

		// JWT-like structure (header.payload.signature)
		// Note: Each part should be valid base64, but we're testing individual parts
		$jwtHeader = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9';
		$this->assertTrue( $validator->isValid( $jwtHeader ) );

		// Binary data
		$binaryData = random_bytes( 32 );
		$this->assertTrue( $validator->isValid( base64_encode( $binaryData ) ) );
	}
}
