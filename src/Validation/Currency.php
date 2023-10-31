<?php

namespace Neuron\Validation;

/**
 * Requires a number with a maximum of 2 decimal places.
 */
class Currency extends Base
{
	public function validate( $data ) : bool
	{
		return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $data ) == 1 ? true : false;
	}
}
