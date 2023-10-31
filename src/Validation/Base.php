<?php

namespace Neuron\Validation;

/**
 * Validator base class.
 */

abstract class Base implements IValidator
{
	abstract protected function validate( $data ) : bool;

	public function __construct()
	{
		return $this;
	}

	/**
	 * Returns true if validation is successful
	 *
	 * @param $data
	 * @return bool
	 */

	public function isValid( $data ) : bool
	{
		return $this->validate( $data );
	}
}
