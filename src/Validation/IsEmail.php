<?php

namespace Neuron\Validation;

/**
 * Requires a valid email address format.
 */
class IsEmail extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function validate( mixed $value ) : bool
	{
		return (bool)filter_var( $value, FILTER_VALIDATE_EMAIL );
	}
}
