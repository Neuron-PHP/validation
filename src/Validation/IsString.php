<?php

namespace Neuron\Validation;

/**
 * Requires a string.
 */
class IsString extends Base
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
		return is_string( $value );
	}
}
