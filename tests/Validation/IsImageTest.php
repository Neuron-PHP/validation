<?php

use Neuron\Validation\IsImage;
use PHPUnit\Framework\TestCase;

class IsImageTest extends TestCase
{
	/**
	 * Test valid base64 encoded JPEG image.
	 */
	public function testValidBase64JpegImage()
	{
		// Small 1x1 pixel JPEG image in base64
		$jpegBase64 = '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAr/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=';

		$validator = new IsImage();
		$this->assertTrue( $validator->isValid( $jpegBase64 ) );
	}

	/**
	 * Test valid data URI formatted JPEG image.
	 */
	public function testValidDataUriJpegImage()
	{
		// Small 1x1 pixel JPEG image as data URI
		$jpegDataUri = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAr/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=';

		$validator = new IsImage();
		$this->assertTrue( $validator->isValid( $jpegDataUri ) );
	}

	/**
	 * Test valid base64 encoded PNG image.
	 */
	public function testValidBase64PngImage()
	{
		// Small 1x1 pixel PNG image in base64
		$pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

		$validator = new IsImage();
		$this->assertTrue( $validator->isValid( $pngBase64 ) );
	}

	/**
	 * Test valid data URI formatted PNG image.
	 */
	public function testValidDataUriPngImage()
	{
		// Small 1x1 pixel PNG image as data URI
		$pngDataUri = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

		$validator = new IsImage();
		$this->assertTrue( $validator->isValid( $pngDataUri ) );
	}

	/**
	 * Test valid base64 encoded GIF image.
	 */
	public function testValidBase64GifImage()
	{
		// Small 1x1 pixel GIF image in base64
		$gifBase64 = 'R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

		$validator = new IsImage();
		$this->assertTrue( $validator->isValid( $gifBase64 ) );
	}

	/**
	 * Test invalid base64 string.
	 */
	public function testInvalidBase64String()
	{
		$invalidBase64 = 'This is not base64!@#$%';

		$validator = new IsImage();
		$this->assertFalse( $validator->isValid( $invalidBase64 ) );
	}

	/**
	 * Test valid base64 but not an image.
	 */
	public function testValidBase64NotImage()
	{
		// Base64 encoded text "Hello World"
		$textBase64 = 'SGVsbG8gV29ybGQ=';

		$validator = new IsImage();
		$this->assertFalse( $validator->isValid( $textBase64 ) );
	}

	/**
	 * Test empty string.
	 */
	public function testEmptyString()
	{
		$validator = new IsImage();
		$this->assertFalse( $validator->isValid( '' ) );
	}

	/**
	 * Test non-string input.
	 */
	public function testNonStringInput()
	{
		$validator = new IsImage();
		$this->assertFalse( $validator->isValid( 123 ) );
		$this->assertFalse( $validator->isValid( [] ) );
		$this->assertFalse( $validator->isValid( null ) );
		$this->assertFalse( $validator->isValid( true ) );
	}

	/**
	 * Test MIME type restrictions.
	 */
	public function testMimeTypeRestrictions()
	{
		// Only allow JPEG images
		$validator = new IsImage( [ 'image/jpeg' ] );

		// JPEG should pass
		$jpegBase64 = '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAr/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=';
		$this->assertTrue( $validator->isValid( $jpegBase64 ) );

		// PNG should fail
		$pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
		$this->assertFalse( $validator->isValid( $pngBase64 ) );
	}

	/**
	 * Test data URI MIME type restrictions.
	 */
	public function testDataUriMimeTypeRestrictions()
	{
		// Only allow PNG images
		$validator = new IsImage( [ 'image/png' ] );

		// PNG data URI should pass
		$pngDataUri = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
		$this->assertTrue( $validator->isValid( $pngDataUri ) );

		// JPEG data URI should fail
		$jpegDataUri = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAr/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=';
		$this->assertFalse( $validator->isValid( $jpegDataUri ) );
	}

	/**
	 * Test file size restrictions.
	 */
	public function testFileSizeRestrictions()
	{
		// Small PNG (should be < 100 bytes decoded)
		$smallPng = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

		// Allow max 200 bytes
		$validator200 = new IsImage( [], 200 );
		$this->assertTrue( $validator200->isValid( $smallPng ) );

		// Allow max 10 bytes (should fail)
		$validator10 = new IsImage( [], 10 );
		$this->assertFalse( $validator10->isValid( $smallPng ) );
	}

	/**
	 * Test without image data checking (faster validation).
	 */
	public function testWithoutImageDataChecking()
	{
		// Validator that doesn't check actual image data
		$validator = new IsImage( [], null, false );

		// Valid base64 but not an image - should pass when not checking image data
		$textBase64 = 'SGVsbG8gV29ybGQ='; // "Hello World"
		$this->assertTrue( $validator->isValid( $textBase64 ) );

		// Invalid base64 should still fail
		$invalidBase64 = 'Not valid base64!@#';
		$this->assertFalse( $validator->isValid( $invalidBase64 ) );
	}

	/**
	 * Test SVG image support.
	 */
	public function testSvgImageSupport()
	{
		// Simple SVG in base64
		$svgContent = '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"></svg>';
		$svgBase64 = base64_encode( $svgContent );

		$validator = new IsImage();
		$this->assertTrue( $validator->isValid( $svgBase64 ) );

		// SVG data URI
		$svgDataUri = 'data:image/svg+xml;base64,' . $svgBase64;
		$this->assertTrue( $validator->isValid( $svgDataUri ) );
	}

	/**
	 * Test malformed data URI.
	 */
	public function testMalformedDataUri()
	{
		$validator = new IsImage();

		// Missing base64 declaration
		$malformed1 = 'data:image/png,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAB';
		$this->assertFalse( $validator->isValid( $malformed1 ) );

		// Missing MIME type
		$malformed2 = 'data:;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAB';
		$this->assertFalse( $validator->isValid( $malformed2 ) );

		// Completely invalid format
		$malformed3 = 'data:not-a-valid-uri';
		$this->assertFalse( $validator->isValid( $malformed3 ) );
	}
}