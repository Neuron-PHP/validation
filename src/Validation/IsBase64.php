<?php

namespace Neuron\Validation;

/**
 * Validates base64 encoded data.
 */
class IsBase64 extends Base
{
	private bool $AllowUrlSafe;

	/**
	 * @param bool $AllowUrlSafe Whether to allow URL-safe base64 variant (RFC 4648)
	 */
	public function __construct( bool $AllowUrlSafe = true )
	{
		parent::__construct();
		$this->AllowUrlSafe = $AllowUrlSafe;
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

		// Empty string is not valid base64
		if( $value === '' )
		{
			return false;
		}

		// Remove whitespace for validation (base64 can contain whitespace in some contexts)
		$cleanValue = preg_replace( '/\s+/', '', $value );

		// If URL-safe variant is allowed, convert it to standard base64
		if( $this->AllowUrlSafe )
		{
			$cleanValue = strtr( $cleanValue, '-_', '+/' );
		}

		// Attempt to decode with strict mode
		$decoded = base64_decode( $cleanValue, true );

		// If decode fails, it's not valid base64
		if( $decoded === false )
		{
			return false;
		}

		// Re-encode and compare to ensure it's properly formatted base64
		// This catches cases where the string might decode but isn't valid base64
		return base64_encode( $decoded ) === $cleanValue;
	}
}
