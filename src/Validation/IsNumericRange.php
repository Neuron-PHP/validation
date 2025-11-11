<?php

namespace Neuron\Validation;

/**
 * Requires the Minimum to be less than the maximum.
 */
class IsNumericRange extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $value
	 * @return bool
	 */
	protected function validate( $value ) : bool
	{
		return ( $value->minimum < $value->maximum );
	}
}
