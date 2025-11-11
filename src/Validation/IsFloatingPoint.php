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
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		if( is_string( $value ) )
		{
			return $value == ( (string)(float)$value );
		}

		return is_float( $value );
	}
}
