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
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		return (bool)filter_var( $value, FILTER_VALIDATE_IP );
	}
}
