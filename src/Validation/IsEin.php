<?php

namespace Neuron\Validation;

/**
 * Requires a valid ein format of nn-nnnnnnn
 */
class IsEin extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param mixed $Value
	 * @return bool
	 */
	public function validate( mixed $Value ) : bool
	{
		return preg_match( "/^[0-9]{2}-[0-9]{7}$/", $Value ) == 1 ? true : false;
	}
}
