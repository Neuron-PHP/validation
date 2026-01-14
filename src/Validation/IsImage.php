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

		// If SVG is explicitly allowed AND we have MIME type restrictions, add SVG to allowed list
		// Don't add if allowedMimeTypes is empty (meaning allow all types)
		if( $this->allowSvg && !empty( $this->allowedMimeTypes ) && !in_array( 'image/svg+xml', $this->allowedMimeTypes, true ) )
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
		// Use 's' modifier to allow . to match newlines in base64 data
		$pattern = '/^data:([a-zA-Z0-9][a-zA-Z0-9\/+\-]*);base64,(.+)$/s';

		if( !preg_match( $pattern, $dataUri, $matches ) )
		{
			return false;
		}

		$mimeType = strtolower( $matches[1] ); // Normalize to lowercase per RFC 2045
		$base64Data = $matches[2];

		// Check MIME type (case-insensitive per RFC 2045)
		if( !empty( $this->allowedMimeTypes ) && !$this->isMimeTypeAllowed( $mimeType ) )
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

		// Always validate image data to check MIME type restrictions
		// Even when checkImageData is false, we need to detect the type for MIME validation
		// but we can skip the more expensive image content validation
		if( !empty( $this->allowedMimeTypes ) )
		{
			// Detect the image type from signatures
			$detectedType = $this->detectImageType( $decoded );

			// Check for SVG if:
			// 1. allowSvg is true (general SVG support enabled), OR
			// 2. 'image/svg+xml' is explicitly in allowedMimeTypes
			$svgExplicitlyAllowed = $this->isMimeTypeAllowed( 'image/svg+xml' );
			if( $detectedType === null && ( $this->allowSvg || $svgExplicitlyAllowed ) )
			{
				$detectedType = $this->detectSvg( $decoded );
			}

			// If we couldn't detect a type, it's not a valid image
			if( $detectedType === null )
			{
				return false;
			}

			// Check if detected type is allowed
			if( !$this->isMimeTypeAllowed( $detectedType ) )
			{
				return false;
			}
		}
		elseif( $this->checkImageData )
		{
			// No MIME restrictions but need to check if it's a recognizable image
			return $this->isRecognizableImage( $decoded );
		}

		return true;
	}

	/**
	 * Detects image type from binary data signatures.
	 *
	 * @param string $imageData
	 * @return string|null Returns MIME type if detected, null otherwise
	 */
	private function detectImageType( string $imageData ) : ?string
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
		foreach( $signatures as $signature => $mimeType )
		{
			if( strpos( $dataStart, $signature ) === 0 )
			{
				// Special handling for WebP
				if( $signature === 'RIFF' && substr( $imageData, 8, 4 ) !== 'WEBP' )
				{
					continue;
				}

				return $mimeType;
			}
		}

		return null;
	}

	/**
	 * Checks if the decoded data is a recognizable image format.
	 * This method only validates that the data contains valid image signatures,
	 * without checking MIME type restrictions (caller's responsibility).
	 *
	 * @param string $imageData
	 * @return bool
	 */
	private function isRecognizableImage( string $imageData ) : bool
	{
		// Use the extracted method to detect image type
		$detectedType = $this->detectImageType( $imageData );

		// Check for SVG if:
		// 1. allowSvg is true (general SVG support enabled), OR
		// 2. 'image/svg+xml' is explicitly in allowedMimeTypes (if any restrictions exist)
		$svgExplicitlyAllowed = !empty( $this->allowedMimeTypes ) && $this->isMimeTypeAllowed( 'image/svg+xml' );
		if( $detectedType === null && ( $this->allowSvg || $svgExplicitlyAllowed ) )
		{
			$detectedType = $this->detectSvg( $imageData );
		}

		// Return true if we recognized any valid image format
		return $detectedType !== null;
	}

	/**
	 * Checks if a MIME type is in the allowed list (case-insensitive per RFC 2045).
	 *
	 * @param string $mimeType
	 * @return bool
	 */
	private function isMimeTypeAllowed( string $mimeType ) : bool
	{
		$normalizedMimeType = strtolower( $mimeType );
		foreach( $this->allowedMimeTypes as $allowed )
		{
			if( strtolower( $allowed ) === $normalizedMimeType )
			{
				return true;
			}
		}
		return false;
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

		// Remove UTF-8 BOM if present (exact 3-byte sequence)
		if( substr( $dataToCheck, 0, 3 ) === "\xEF\xBB\xBF" )
		{
			$dataToCheck = substr( $dataToCheck, 3 );
		}

		// Case-insensitive check for <svg tag with proper namespace
		// Must find an actual SVG element with namespace declaration
		// This regex ensures xmlns is an attribute, not just text content
		if( preg_match( '/<svg\b[^>]*xmlns\s*=\s*["\']http:\/\/www\.w3\.org\/2000\/svg["\'][^>]*>/i', $dataToCheck ) )
		{
			// Valid SVG with proper namespace declaration
			return 'image/svg+xml';
		}

		// Also check for xmlns:svg pattern (less common but valid)
		if( preg_match( '/<svg\b[^>]*xmlns:svg\s*=\s*["\']http:\/\/www\.w3\.org\/2000\/svg["\'][^>]*>/i', $dataToCheck ) )
		{
			return 'image/svg+xml';
		}

		return null;
	}
}