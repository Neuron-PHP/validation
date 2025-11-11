<?php

namespace Neuron\Validation;

/**
 * Requires an integer or float or a numeric string
 */
class IsNumeric extends Base
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
		return is_numeric( $value );
	}
}
