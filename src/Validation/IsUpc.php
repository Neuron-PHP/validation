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
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value) : bool
	{
		// validate upc code
		if (preg_match( '/^[0-9]{12}$/', $Value))
		{
			$check = 0;
			for ($i = 0; $i < 11; $i += 2) {
				$check += $Value[ $i];
			}
			$check *= 3;
			for ($i = 1; $i < 11; $i += 2) {
				$check += $Value[ $i];
			}
			return ( $Value[ 11] == ((10 - ($check % 10)) % 10));
		}
		return false;
	}
}
