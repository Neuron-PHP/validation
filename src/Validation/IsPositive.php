<?php

namespace Neuron\Validation;

/**
 * Requires a positive number.
 */
class IsPositive extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $value
	 * @return bool
	 */
	public function validate( $value ) : bool
	{
		return !( $value < 0 );
	}
}
