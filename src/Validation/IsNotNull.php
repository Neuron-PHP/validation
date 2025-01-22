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
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		return !is_null( $Value );
	}
}
