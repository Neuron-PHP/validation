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
class IsName extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $Value
	 * @return bool
	 */
	public function validate( mixed $Value ) : bool
	{
		return preg_match( "/^[a-zA-Z,. ]*$/", $Value ) == 1;
	}
}
