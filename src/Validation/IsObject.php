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
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		return is_object( $value );
	}
}
