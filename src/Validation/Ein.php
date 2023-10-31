<?php

namespace Neuron\Validation;

/**
 * Requires a valid ein format of nn-nnnnnnn
 */
class Ein extends Base
{
	public function validate( $data ) : bool
	{
		return preg_match("/^[0-9]{2}-[0-9]{7}$/", $data ) == 1 ? true : false;
	}
}
