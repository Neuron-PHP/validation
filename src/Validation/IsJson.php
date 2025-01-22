<?php

namespace Neuron\Validation;

/**
 * Validates json data.
 */
class IsJson extends Base
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
		if( !is_string( $Value ) )
		{
			return false;
		}

		return !is_null( json_decode( $Value ) );
	}
}
