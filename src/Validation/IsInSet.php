<?php

namespace Neuron\Validation;

/**
 * Validates that a value is within a predefined set of allowed values.
 *
 * This validator is commonly used for enum-like validations where a value
 * must be one of a specific set of allowed options. It supports both strict
 * and loose comparison modes.
 *
 * @package Neuron\Validation
 *
 * @example
 * ```php
 * // Validate user role
 * $roleValidator = new IsInSet(['admin', 'editor', 'author', 'subscriber']);
 * $roleValidator->isValid('admin'); // true
 * $roleValidator->isValid('moderator'); // false
 *
 * // Validate with loose comparison
 * $statusValidator = new IsInSet([1, 2, 3], false);
 * $statusValidator->isValid('2'); // true (loose comparison)
 * ```
 */
class IsInSet extends Base
{
	private array $_allowedValues;
	private bool $_strict;

	/**
	 * @param array $allowedValues Array of allowed values
	 * @param bool $strict Whether to use strict comparison (default: true)
	 */
	public function __construct( array $allowedValues, bool $strict = true )
	{
		$this->_allowedValues = $allowedValues;
		$this->_strict = $strict;
		parent::__construct();
	}

	/**
	 * Get the array of allowed values.
	 *
	 * @return array
	 */
	public function getAllowedValues(): array
	{
		return $this->_allowedValues;
	}

	/**
	 * Set the array of allowed values.
	 *
	 * @param array $allowedValues
	 * @return void
	 */
	public function setAllowedValues( array $allowedValues ): void
	{
		$this->_allowedValues = $allowedValues;
	}

	/**
	 * Check if strict comparison is enabled.
	 *
	 * @return bool
	 */
	public function isStrict(): bool
	{
		return $this->_strict;
	}

	/**
	 * Set whether to use strict comparison.
	 *
	 * @param bool $strict
	 * @return void
	 */
	public function setStrict( bool $strict ): void
	{
		$this->_strict = $strict;
	}

	/**
	 * Validates that the value is in the allowed set.
	 *
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ): bool
	{
		return in_array( $value, $this->_allowedValues, $this->_strict );
	}
}
