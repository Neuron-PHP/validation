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
	 * @param $Value
	 * @return bool
	 */
	public function validate( $Value ) : bool
	{
		return !( $Value < 0 );
	}
}
