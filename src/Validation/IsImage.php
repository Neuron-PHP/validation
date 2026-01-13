<?php

namespace Neuron\Validation;

/**
 * Validates image data, supporting base64 encoded images with optional MIME type and size constraints.
 */
class IsImage extends Base
{
	private array $allowedMimeTypes;
	private ?int $maxSize;
	private bool $checkImageData;
	private bool $allowSvg;

	/**
	 * @param array $allowedMimeTypes List of allowed MIME types (e.g., ['image/jpeg', 'image/png'])
	 * @param int|null $maxSize Maximum file size in bytes (null for no limit)
	 * @param bool $checkImageData Whether to validate the actual image data (requires decoding)
	 * @param bool $allowSvg Whether to allow SVG images (default: false for security - SVG can contain scripts)
	 */
	public function __construct(
		array $allowedMimeTypes = [ 'image/jpeg', 'image/png', 'image/gif', 'image/webp' ],
		?int $maxSize = null,
		bool $checkImageData = true,
		bool $allowSvg = false
	)
	{
		parent::__construct();
		$this->allowedMimeTypes = $allowedMimeTypes;
		$this->maxSize = $maxSize;
		$this->checkImageData = $checkImageData;
		$this->allowSvg = $allowSvg;

		// If SVG is explicitly allowed, add it to allowed MIME types
		if( $this->allowSvg && !in_array( 'image/svg+xml', $this->allowedMimeTypes, true ) )
		{
			$this->allowedMimeTypes[] = 'image/svg+xml';
		}
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		if( !is_string( $value ) )
		{
			return false;
		}

		// Empty string is not a valid image
		if( $value === '' )
		{
			return false;
		}

		// Check if it's a data URI
		if( strpos( $value, 'data:' ) === 0 )
		{
			return $this->validateDataUri( $value );
		}

		// Otherwise, treat it as base64 encoded image data
		return $this->validateBase64Image( $value );
	}

	/**
	 * Validates a data URI formatted image.
	 *
	 * @param string $dataUri
	 * @return bool
	 */
	private function validateDataUri( string $dataUri ) : bool
	{
		// Parse data URI: data:[<mediatype>][;base64],<data>
		$pattern = '/^data:([a-zA-Z0-9][a-zA-Z0-9\/+\-]*);base64,(.+)$/';

		if( !preg_match( $pattern, $dataUri, $matches ) )
		{
			return false;
		}

		$mimeType = $matches[1];
		$base64Data = $matches[2];

		// Check MIME type
		if( !empty( $this->allowedMimeTypes ) && !in_array( $mimeType, $this->allowedMimeTypes, true ) )
		{
			return false;
		}

		// Validate base64 data
		return $this->validateBase64Image( $base64Data );
	}

	/**
	 * Validates base64 encoded image data.
	 *
	 * @param string $base64Data
	 * @return bool
	 */
	private function validateBase64Image( string $base64Data ) : bool
	{
		// Remove any whitespace
		$cleanData = preg_replace( '/\s+/', '', $base64Data );

		// Attempt to decode
		$decoded = base64_decode( $cleanData, true );

		if( $decoded === false )
		{
			return false;
		}

		// Check size constraint
		if( $this->maxSize !== null && strlen( $decoded ) > $this->maxSize )
		{
			return false;
		}

		// If we need to check the actual image data
		if( $this->checkImageData )
		{
			return $this->validateImageData( $decoded );
		}

		return true;
	}

	/**
	 * Validates that the decoded data is actually a valid image.
	 *
	 * @param string $imageData
	 * @return bool
	 */
	private function validateImageData( string $imageData ) : bool
	{
		// Check for common image file signatures (magic numbers)
		$signatures = [
			// JPEG
			"\xFF\xD8\xFF" => 'image/jpeg',
			// PNG
			"\x89\x50\x4E\x47\x0D\x0A\x1A\x0A" => 'image/png',
			// GIF
			"GIF87a" => 'image/gif',
			"GIF89a" => 'image/gif',
			// WebP
			"RIFF" => 'image/webp', // Note: WebP also needs WEBP at offset 8
		];

		$dataStart = substr( $imageData, 0, 20 );

		// Check for image signatures
		$detectedType = null;
		foreach( $signatures as $signature => $mimeType )
		{
			if( strpos( $dataStart, $signature ) === 0 )
			{
				// Special handling for WebP
				if( $signature === 'RIFF' && substr( $imageData, 8, 4 ) !== 'WEBP' )
				{
					continue;
				}

				$detectedType = $mimeType;
				break;
			}
		}

		// Check for SVG separately with more strict validation
		if( $detectedType === null && $this->allowSvg )
		{
			$detectedType = $this->detectSvg( $imageData );
		}

		// If no signature matched, it's not a valid image
		if( $detectedType === null )
		{
			return false;
		}

		// Check if detected type is in allowed MIME types
		if( !empty( $this->allowedMimeTypes ) && !in_array( $detectedType, $this->allowedMimeTypes, true ) )
		{
			return false;
		}

		return true;
	}

	/**
	 * Detects if the data is a valid SVG image.
	 * SVG detection is more permissive but requires explicit opt-in for security.
	 *
	 * @param string $imageData
	 * @return string|null Returns 'image/svg+xml' if valid SVG, null otherwise
	 */
	private function detectSvg( string $imageData ) : ?string
	{
		// Only check first 1KB for performance
		$dataToCheck = substr( $imageData, 0, 1024 );

		// Remove any BOM (Byte Order Mark)
		$dataToCheck = ltrim( $dataToCheck, "\xEF\xBB\xBF" );

		// Case-insensitive check for <svg tag
		// Must find an actual SVG element, not just XML declaration
		if( preg_match( '/<svg\b[^>]*>/i', $dataToCheck ) )
		{
			// Additional validation: check for xmlns attribute (standard in valid SVG)
			if( stripos( $dataToCheck, 'xmlns' ) !== false ||
			    stripos( $dataToCheck, 'http://www.w3.org/2000/svg' ) !== false )
			{
				return 'image/svg+xml';
			}

			// Even without xmlns, if we have an svg tag, it's likely SVG
			// But we're being more strict here for security
			return 'image/svg+xml';
		}

		return null;
	}
}