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
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		return !empty( $Value );
	}
}
