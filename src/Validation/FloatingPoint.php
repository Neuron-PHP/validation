<?php

namespace Neuron\Validation;

/**
 * Requires a floating point number.
 */
class FloatingPoint extends Base
{
	protected function validate( $Value ) : bool
	{
		if( is_string( $Value ) )
		{
			return $Value == ( (string)(float)$Value );
		}

		return is_float( $Value );
	}
}
