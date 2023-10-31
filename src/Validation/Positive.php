<?php

namespace Neuron\Validation;

/**
 * Requires a positive number.
 */
class Positive extends Base
{
	public function validate( $Data ) : bool
	{
		return !( $Data < 0 );
	}
}
