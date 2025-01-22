<?php

namespace Neuron\Validation;

/**
 * Requires an integer
 */
class IsInteger extends Base
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
		if( is_int( $Value ) )
		{
			return true;
		}

		return false;
	}
}
