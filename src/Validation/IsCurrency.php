<?php

namespace Neuron\Validation;

/**
 * Requires a number with a maximum of 2 decimal places.
 */
class IsCurrency extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Validates if the value is in a currency format.
	 *
	 * @param mixed $Value
	 * @return bool
	 */
	public function validate( mixed $Value ) : bool
	{
		return preg_match( "/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $Value ) == 1 ? true : false;
	}
}
