<?php

namespace Neuron\Validation;

/**
 * Data validation.
 */
interface IValidator
{
	/**
	 * Determines if the provided value meets the validity criteria.
	 *
	 * @param mixed $Value The value to be validated.
	 * @return bool Returns true if the value is valid, otherwise false.
	 */
	public function isValid( mixed $Value ) : bool;
}
