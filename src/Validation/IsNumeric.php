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
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		return is_numeric( $Value );
	}
}
