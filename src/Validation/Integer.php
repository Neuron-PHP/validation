<?php

namespace Neuron\Validation;

/**
 * Requires an integer
 */
class Integer extends Base
{
	protected function validate( $integer ) : bool
	{
		if( is_int( $integer ) )
		{
			return true;
		}

		return ctype_digit( $integer );
	}
}
