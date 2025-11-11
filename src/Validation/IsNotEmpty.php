<?php

namespace Neuron\Validation;

/**
 * Requires a non empty variable.
 */
class IsNotEmpty extends Base
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
		return !empty( $value );
	}
}
