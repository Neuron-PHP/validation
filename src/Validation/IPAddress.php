<?php


namespace Neuron\Validation;

/**
 * Requires a valid IPAddress format.
 */
class IPAddress extends Base
{
	protected function validate( $address ) : bool
	{
		return filter_var( $address, FILTER_VALIDATE_IP )? true : false;
	}
}
