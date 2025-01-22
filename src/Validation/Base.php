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
	 * @param mixed $Value
	 * @return bool
	 */
	abstract protected function validate( mixed $Value ) : bool;

	/**
	 * Returns true if validation is successful
	 *
	 * @param mixed $Value
	 * @return bool
	 */
	public function isValid( mixed $Value ) : bool
	{
		return $this->validate( $Value );
	}
}
