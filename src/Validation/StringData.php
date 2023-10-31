<?php

namespace Neuron\Validation;

/**
 * Requires a string.
 */
class StringData extends Base
{
	protected function validate( $string ) : bool
	{
		return is_string( $string );
	}
}
