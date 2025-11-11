<?php

namespace Neuron\Validation;

/**
 * Validates a UPC code.
 */
class IsUpc extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value) : bool
	{
		// validate upc code
		if (preg_match( '/^[0-9]{12}$/', $value))
		{
			$check = 0;
			for ($i = 0; $i < 11; $i += 2) {
				$check += $value[ $i];
			}
			$check *= 3;
			for ($i = 1; $i < 11; $i += 2) {
				$check += $value[ $i];
			}
			return ( $value[ 11] == ((10 - ($check % 10)) % 10));
		}
		return false;
	}
}
