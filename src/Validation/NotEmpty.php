<?php

namespace Neuron\Validation;

/**
 * Requires a non empty variable.
 */
class NotEmpty extends Base
{
	protected function validate( $data ) : bool
	{
		return !empty( $data );
	}
}
