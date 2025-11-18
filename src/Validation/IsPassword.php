<?php

namespace Neuron\Validation;

/**
 * Password validator with configurable requirements.
 *
 * Validates password strength based on configurable criteria including
 * length, character types (uppercase, lowercase, digits, special characters).
 * Provides flexible password policy enforcement for various security requirements.
 *
 * @package Neuron\Validation
 *
 * @example
 * ```php
 * // Simple length-only validation (minimum 8 characters)
 * $validator = new IsPassword( 8 );
 *
 * // Complex password policy (8-64 chars, requires upper, lower, digit, special)
 * $validator = new IsPassword( 12, 64, true, true, true, true );
 *
 * // Custom policy with specific requirements
 * $validator = new IsPassword(
 *     minLength: 10,
 *     maxLength: 128,
 *     requireUppercase: true,
 *     requireLowercase: true,
 *     requireDigit: true,
 *     requireSpecial: true,
 *     specialChars: '@#$%'
 * );
 *
 * if( $validator->isValid( 'MyP@ssw0rd' ) ) {
 *     echo "Password is valid";
 * }
 * ```
 */
class IsPassword extends Base
{
	private int $_minLength;
	private ?int $_maxLength;
	private bool $_requireUppercase;
	private bool $_requireLowercase;
	private bool $_requireDigit;
	private bool $_requireSpecial;
	private string $_specialChars;

	/**
	 * Constructor to initialize password validation requirements.
	 *
	 * @param int $minLength Minimum password length (required)
	 * @param int|null $maxLength Maximum password length, null for no limit (default: null)
	 * @param bool $requireUppercase Require at least one uppercase letter (default: false)
	 * @param bool $requireLowercase Require at least one lowercase letter (default: false)
	 * @param bool $requireDigit Require at least one digit (default: false)
	 * @param bool $requireSpecial Require at least one special character (default: false)
	 * @param string $specialChars Set of allowed special characters (default: !@#$%^&*()_+-=[]{}|;:,.<>?)
	 * @return void
	 */
	public function __construct(
		int $minLength,
		?int $maxLength = null,
		bool $requireUppercase = false,
		bool $requireLowercase = false,
		bool $requireDigit = false,
		bool $requireSpecial = false,
		string $specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?'
	)
	{
		parent::__construct();

		$this->_minLength = $minLength;
		$this->_maxLength = $maxLength;
		$this->_requireUppercase = $requireUppercase;
		$this->_requireLowercase = $requireLowercase;
		$this->_requireDigit = $requireDigit;
		$this->_requireSpecial = $requireSpecial;
		$this->_specialChars = $specialChars;
	}

	/**
	 * Validates the password against configured requirements.
	 *
	 * @param mixed $value The password to validate
	 * @return bool True if the password meets all requirements, false otherwise
	 */
	protected function validate( mixed $value ) : bool
	{
		// Must be a string
		if( !is_string( $value ) )
		{
			return false;
		}

		$length = strlen( $value );

		// Check minimum length
		if( $length < $this->_minLength )
		{
			return false;
		}

		// Check maximum length if specified
		if( $this->_maxLength !== null && $length > $this->_maxLength )
		{
			return false;
		}

		// Check uppercase requirement
		if( $this->_requireUppercase && !preg_match( '/[A-Z]/', $value ) )
		{
			return false;
		}

		// Check lowercase requirement
		if( $this->_requireLowercase && !preg_match( '/[a-z]/', $value ) )
		{
			return false;
		}

		// Check digit requirement
		if( $this->_requireDigit && !preg_match( '/[0-9]/', $value ) )
		{
			return false;
		}

		// Check special character requirement
		if( $this->_requireSpecial )
		{
			$escapedSpecialChars = preg_quote( $this->_specialChars, '/' );
			if( !preg_match( '/[' . $escapedSpecialChars . ']/', $value ) )
			{
				return false;
			}
		}

		return true;
	}
}
