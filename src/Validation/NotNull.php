<?php

namespace Neuron\Validation;

/**
 * Requires a non-null variable.
 */
class NotNull extends Base
{
	protected function validate( $data ) : bool
	{
		return !is_null( $data );
	}
}
