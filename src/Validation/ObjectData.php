<?php

namespace Neuron\Validation;

/**
 * Requires an array.
 */
class ObjectData extends Base
{
	protected function validate( $Object ) : bool
	{
		return is_object( $Object );
	}
}
