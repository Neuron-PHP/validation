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

	/**
	 * @param array $allowedMimeTypes List of allowed MIME types (e.g., ['image/jpeg', 'image/png'])
	 * @param int|null $maxSize Maximum file size in bytes (null for no limit)
	 * @param bool $checkImageData Whether to validate the actual image data (requires decoding)
	 */
	public function __construct(
		array $allowedMimeTypes = [ 'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml' ],
		?int $maxSize = null,
		bool $checkImageData = true
	)
	{
		parent::__construct();
		$this->allowedMimeTypes = $allowedMimeTypes;
		$this->maxSize = $maxSize;
		$this->checkImageData = $checkImageData;
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
			// SVG (XML-based, check for common SVG patterns)
			"<?xml" => 'image/svg+xml',
			"<svg" => 'image/svg+xml'
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
}