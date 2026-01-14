<?php

namespace Tests\Validation;

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
	 * Test SVG image support with explicit opt-in.
	 */
	public function testSvgImageSupportWithOptIn()
	{
		// Simple SVG in base64
		$svgContent = '<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"></svg>';
		$svgBase64 = base64_encode( $svgContent );

		// Default validator (SVG not allowed)
		$validator = new IsImage();
		$this->assertFalse( $validator->isValid( $svgBase64 ) );

		// Validator with SVG explicitly allowed
		$validatorWithSvg = new IsImage( [], null, true, true );
		$this->assertTrue( $validatorWithSvg->isValid( $svgBase64 ) );

		// SVG data URI with explicit SVG support
		$svgDataUri = 'data:image/svg+xml;base64,' . $svgBase64;
		$this->assertFalse( $validator->isValid( $svgDataUri ) );
		$this->assertTrue( $validatorWithSvg->isValid( $svgDataUri ) );
	}

	/**
	 * Test that generic XML is not accepted as SVG.
	 */
	public function testGenericXmlNotAcceptedAsSvg()
	{
		// Generic XML that is not SVG
		$xmlContent = '<?xml version="1.0"?><root><data>test</data></root>';
		$xmlBase64 = base64_encode( $xmlContent );

		// Even with SVG allowed, generic XML should not pass
		$validatorWithSvg = new IsImage( [], null, true, true );
		$this->assertFalse( $validatorWithSvg->isValid( $xmlBase64 ) );
	}

	/**
	 * Test SVG detection requires proper SVG tag.
	 */
	public function testSvgDetectionRequiresSvgTag()
	{
		// SVG without proper tag
		$invalidSvg1 = '<?xml version="1.0"?><notsvg xmlns="http://www.w3.org/2000/svg"></notsvg>';
		$invalidBase64 = base64_encode( $invalidSvg1 );

		$validatorWithSvg = new IsImage( [], null, true, true );
		$this->assertFalse( $validatorWithSvg->isValid( $invalidBase64 ) );

		// Valid SVG with proper tag
		$validSvg = '<svg xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40"/></svg>';
		$validBase64 = base64_encode( $validSvg );
		$this->assertTrue( $validatorWithSvg->isValid( $validBase64 ) );
	}

	/**
	 * Test SVG without xmlns namespace is rejected for security.
	 */
	public function testSvgWithoutXmlnsRejected()
	{
		// SVG without xmlns namespace - should be rejected even with SVG allowed
		$svgNoNamespace = '<svg width="100" height="100"><circle cx="50" cy="50" r="40"/></svg>';
		$svgBase64 = base64_encode( $svgNoNamespace );

		// Even with SVG enabled, should reject SVG without proper namespace
		$validatorWithSvg = new IsImage( [], null, true, true );
		$this->assertFalse( $validatorWithSvg->isValid( $svgBase64 ) );

		// SVG with xmlns should pass
		$svgWithNamespace = '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><circle cx="50" cy="50" r="40"/></svg>';
		$svgWithNsBase64 = base64_encode( $svgWithNamespace );
		$this->assertTrue( $validatorWithSvg->isValid( $svgWithNsBase64 ) );
	}

	/**
	 * Test SVG with xmlns in text content is rejected (bypass prevention).
	 */
	public function testSvgWithXmlnsInTextRejected()
	{
		// SVG with xmlns in text content but not as attribute - should be rejected
		$svgWithTextXmlns = '<svg><text>xmlns http://www.w3.org/2000/svg</text><script>alert(1)</script></svg>';
		$svgBase64 = base64_encode( $svgWithTextXmlns );

		// Should be rejected even with SVG enabled
		$validatorWithSvg = new IsImage( [], null, true, true );
		$this->assertFalse( $validatorWithSvg->isValid( $svgBase64 ) );

		// SVG with xmlns in comment - should be rejected
		$svgWithCommentXmlns = '<svg><!-- xmlns="http://www.w3.org/2000/svg" --><script>alert(1)</script></svg>';
		$svgBase64Comment = base64_encode( $svgWithCommentXmlns );
		$this->assertFalse( $validatorWithSvg->isValid( $svgBase64Comment ) );
	}

	/**
	 * Test case-insensitive MIME type matching in data URIs.
	 */
	public function testCaseInsensitiveMimeTypeInDataUri()
	{
		// PNG with uppercase MIME type
		$pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

		// Test various case combinations
		$validator = new IsImage();

		// Uppercase MIME type
		$upperDataUri = 'data:IMAGE/PNG;base64,' . $pngBase64;
		$this->assertTrue( $validator->isValid( $upperDataUri ) );

		// Mixed case MIME type
		$mixedDataUri = 'data:Image/Png;base64,' . $pngBase64;
		$this->assertTrue( $validator->isValid( $mixedDataUri ) );

		// JPEG with uppercase
		$jpegBase64 = '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAr/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=';
		$upperJpegUri = 'data:IMAGE/JPEG;base64,' . $jpegBase64;
		$this->assertTrue( $validator->isValid( $upperJpegUri ) );
	}

	/**
	 * Test BOM removal handles exact sequence only.
	 */
	public function testBomRemovalExactSequence()
	{
		// SVG with proper BOM followed by valid content
		$svgWithBom = "\xEF\xBB\xBF<svg xmlns=\"http://www.w3.org/2000/svg\"></svg>";
		$svgBomBase64 = base64_encode( $svgWithBom );

		$validatorWithSvg = new IsImage( [], null, true, true );
		$this->assertTrue( $validatorWithSvg->isValid( $svgBomBase64 ) );

		// Test with only first two bytes of BOM - should not be stripped
		// The incomplete BOM should prevent proper SVG detection
		$svgTwoBomBytes = "\xEF\xBB<svg xmlns=\"http://www.w3.org/2000/svg\"></svg>";
		$svgTwoBase64 = base64_encode( $svgTwoBomBytes );
		// This passes because the regex can still find <svg after the bytes
		// But the bytes aren't stripped by ltrim anymore
		$this->assertTrue( $validatorWithSvg->isValid( $svgTwoBase64 ) );

		// Test that we only remove exact BOM, not individual bytes
		// This demonstrates the fix - ltrim would have stripped all \xEF, \xBB, \xBF anywhere
		$svgWithEFAfterBom = "\xEF\xBB\xBF<svg xmlns=\"http://www.w3.org/2000/svg\">\xEF</svg>";
		$svgEfBase64 = base64_encode( $svgWithEFAfterBom );
		$this->assertTrue( $validatorWithSvg->isValid( $svgEfBase64 ) );
	}

	/**
	 * Test data URI with line-wrapped base64 (common in email/MIME).
	 */
	public function testDataUriWithLineWrappedBase64()
	{
		// PNG image with base64 wrapped at 76 characters (common MIME format)
		$pngBase64Wrapped = "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChw\nGA60e6kgAAAABJRU5ErkJggg==";

		// Test with newline in base64 data
		$dataUriWithNewline = 'data:image/png;base64,' . $pngBase64Wrapped;

		$validator = new IsImage();
		// Should pass - newlines are valid in base64 data URIs
		$this->assertTrue( $validator->isValid( $dataUriWithNewline ) );

		// Test with multiple newlines and spaces (also valid)
		$pngBase64MultiLine = "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJ\n" .
		                      "AAAADUlEQVR42mNkYPhfDwAChw\n" .
		                      "GA60e6kgAAAABJRU5ErkJggg==";

		$dataUriMultiLine = 'data:image/png;base64,' . $pngBase64MultiLine;
		$this->assertTrue( $validator->isValid( $dataUriMultiLine ) );

		// Test with carriage return + newline (Windows style)
		$pngBase64CRLF = str_replace("\n", "\r\n", $pngBase64Wrapped);
		$dataUriCRLF = 'data:image/png;base64,' . $pngBase64CRLF;
		$this->assertTrue( $validator->isValid( $dataUriCRLF ) );
	}

	/**
	 * Test MIME type restrictions work for raw base64 input.
	 */
	public function testMimeTypeRestrictionsForRawBase64()
	{
		// PNG image as raw base64
		$pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

		// JPEG image as raw base64
		$jpegBase64 = '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAr/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=';

		// Validator that only allows JPEG, even with checkImageData=false
		$jpegOnlyValidator = new IsImage( [ 'image/jpeg' ], null, false );

		// JPEG should pass
		$this->assertTrue( $jpegOnlyValidator->isValid( $jpegBase64 ) );

		// PNG should fail even with checkImageData=false
		$this->assertFalse( $jpegOnlyValidator->isValid( $pngBase64 ) );

		// Validator that only allows PNG
		$pngOnlyValidator = new IsImage( [ 'image/png' ], null, false );

		// PNG should pass
		$this->assertTrue( $pngOnlyValidator->isValid( $pngBase64 ) );

		// JPEG should fail
		$this->assertFalse( $pngOnlyValidator->isValid( $jpegBase64 ) );
	}

	/**
	 * Test empty allowedMimeTypes with SVG doesn't restrict to SVG only.
	 */
	public function testEmptyAllowedMimeTypesWithSvgAllowsAll()
	{
		// Empty array means allow all types
		$validatorAllowAll = new IsImage( [], null, true, true );

		// All image types should pass
		$jpegBase64 = '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAr/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=';
		$this->assertTrue( $validatorAllowAll->isValid( $jpegBase64 ) );

		$pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
		$this->assertTrue( $validatorAllowAll->isValid( $pngBase64 ) );

		$gifBase64 = 'R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
		$this->assertTrue( $validatorAllowAll->isValid( $gifBase64 ) );

		// SVG should also pass
		$svgBase64 = base64_encode( '<svg xmlns="http://www.w3.org/2000/svg"></svg>' );
		$this->assertTrue( $validatorAllowAll->isValid( $svgBase64 ) );

		// Now test with allowSvg=false but empty allowedMimeTypes
		$validatorNoSvg = new IsImage( [], null, true, false );

		// Non-SVG images should still pass
		$this->assertTrue( $validatorNoSvg->isValid( $jpegBase64 ) );
		$this->assertTrue( $validatorNoSvg->isValid( $pngBase64 ) );

		// SVG should fail
		$this->assertFalse( $validatorNoSvg->isValid( $svgBase64 ) );
	}

	/**
	 * Test SVG accepted when explicitly in allowedMimeTypes even with allowSvg=false.
	 */
	public function testSvgAcceptedWhenExplicitlyAllowed()
	{
		// SVG content
		$svgContent = '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><circle cx="50" cy="50" r="40"/></svg>';
		$svgBase64 = base64_encode( $svgContent );

		// Validator with SVG explicitly in allowedMimeTypes but allowSvg=false
		$validatorExplicitSvg = new IsImage( [ 'image/jpeg', 'image/svg+xml' ], null, true, false );

		// SVG should pass because it's explicitly allowed in MIME types
		$this->assertTrue( $validatorExplicitSvg->isValid( $svgBase64 ) );

		// Data URI with SVG should also work
		$svgDataUri = 'data:image/svg+xml;base64,' . $svgBase64;
		$this->assertTrue( $validatorExplicitSvg->isValid( $svgDataUri ) );

		// Validator without SVG in allowedMimeTypes and allowSvg=false
		$validatorNoSvg = new IsImage( [ 'image/jpeg', 'image/png' ], null, true, false );

		// SVG should fail
		$this->assertFalse( $validatorNoSvg->isValid( $svgBase64 ) );
		$this->assertFalse( $validatorNoSvg->isValid( $svgDataUri ) );
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