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

	protected function validate( mixed $Value ) : bool
	{
		return is_array( $Value );
	}
}
