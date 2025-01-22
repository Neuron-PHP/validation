<?php

namespace Neuron\Validation;

/**
 * Requires a valid url format.
 */
class IsUrl extends Base
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
		return (bool)filter_var( $Value, FILTER_VALIDATE_URL );
	}
}
