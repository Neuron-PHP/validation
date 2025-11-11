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
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		if( !is_string( $value ) )
		{
			return false;
		}

		return !is_null( json_decode( $value ) );
	}
}
