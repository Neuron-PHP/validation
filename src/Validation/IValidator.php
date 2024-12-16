<?php

namespace Neuron\Validation;

/**
 * Data validation.
 */
interface IValidator
{
	public function isValid( $data ) : bool;
}
