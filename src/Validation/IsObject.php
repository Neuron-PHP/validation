<?php

namespace Neuron\Validation;

/**
 * Requires an array.
 */
class IsObject extends Base
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		return is_object( $Value );
	}
}
