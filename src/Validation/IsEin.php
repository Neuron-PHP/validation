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
	 * @param mixed $value
	 * @return bool
	 */
	public function validate( mixed $value ) : bool
	{
		return preg_match( "/^[0-9]{2}-[0-9]{7}$/", $value ) == 1 ? true : false;
	}
}
