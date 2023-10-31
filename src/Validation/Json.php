<?php

namespace Neuron\Validation;

/**
 * Validates json data.
 */
class Json extends Base
{
	protected function validate( $Value ) : bool
	{
		if( !is_string( $Value ) )
		{
			return false;
		}

		return !is_null( json_decode( $Value ) );
	}
}
