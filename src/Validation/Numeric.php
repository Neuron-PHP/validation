<?php

namespace Neuron\Validation;

/**
 * Requires an integer or float or a numeric string
 */
class Numeric extends Base
{
	protected function validate( $data ) : bool
	{
		return is_numeric( $data );
	}
}
