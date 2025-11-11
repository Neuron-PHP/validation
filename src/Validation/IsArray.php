<?php

namespace Neuron\Validation;

/**
 * Requires an array.
 */
class IsArray extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function validate( mixed $value ) : bool
	{
		return is_array( $value );
	}
}
