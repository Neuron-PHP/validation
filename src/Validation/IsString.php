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
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		return is_string( $Value );
	}
}
