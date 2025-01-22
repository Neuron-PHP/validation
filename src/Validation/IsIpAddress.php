<?php


namespace Neuron\Validation;

/**
 * Requires a valid IsIpAddress format.
 */
class IsIpAddress extends Base
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
		return (bool)filter_var( $Value, FILTER_VALIDATE_IP );
	}
}
