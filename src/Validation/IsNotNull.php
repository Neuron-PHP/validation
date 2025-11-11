<?php

namespace Neuron\Validation;

/**
 * Requires a non-null variable.
 */
class IsNotNull extends Base
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
		return !is_null( $value );
	}
}
