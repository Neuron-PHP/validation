<?php

namespace Neuron\Validation;

/**
 * Validator base class.
 */

abstract class Base implements IValidator
{
	public function __construct()
	{
	}

	/**
	 * Abstract method to be implemented by all validators.
	 * @param mixed $value
	 * @return bool
	 */
	abstract protected function validate( mixed $value ) : bool;

	/**
	 * Returns true if validation is successful
	 *
	 * @param mixed $value
	 * @return bool
	 */
	public function isValid( mixed $value ) : bool
	{
		return $this->validate( $value );
	}
}
