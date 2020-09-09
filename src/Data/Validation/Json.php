<?php

namespace Neuron\Data\Validation;

/**
 * Validates json data.
 * @package Neuron\Data\Validation
 */
class Json extends Base
{
	protected function validate( $Value )
	{
		if( !is_string( $Value ) )
		{
			return false;
		}

		return !is_null( json_decode( $Value ) );
	}
}
