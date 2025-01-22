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
	 * @param $Value
	 * @return bool
	 */
	protected function validate( $Value ) : bool
	{
		return ( $Value->Minimum < $Value->Maximum );
	}
}
