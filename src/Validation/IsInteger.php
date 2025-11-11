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
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		if( is_int( $value ) )
		{
			return true;
		}

		return false;
	}
}
