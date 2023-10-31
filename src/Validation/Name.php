<?php

namespace Neuron\Validation;

/**
 * Requires a valid name.
 * @todo require at least one space.
 *
 * Allows:
 * 	Upper case letters.
 * 	Lower case letters.
 * 	. and ,
 *
 */
class Name extends Base
{
	public function validate( $data ) : bool
	{
		return preg_match("/^[a-zA-Z,. ]*$/", $data ) == 1 ? true : false;
	}
}
