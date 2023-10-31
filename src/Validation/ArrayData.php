<?php

namespace Neuron\Validation;

/**
 * Requires an array.
 */
class ArrayData extends Base
{
	protected function validate( $Array ) : bool
	{
		return is_array( $Array );
	}
}
