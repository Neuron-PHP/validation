<?php

namespace Neuron\Validation;

/**
 * Requires a floating point number.
 */
class IsFloatingPoint extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		if( is_string( $Value ) )
		{
			return $Value == ( (string)(float)$Value );
		}

		return is_float( $Value );
	}
}
