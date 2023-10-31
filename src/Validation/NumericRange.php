<?php

namespace Neuron\Validation;

/**
 * Requires the Minimum to be less than the maximum.
 */
class NumericRange extends Base
{
	protected function validate( $data ) : bool
	{
		return ( $data->Minimum < $data->Maximum );
	}
}
