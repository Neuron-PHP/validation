<?php

namespace Neuron\Validation;

interface IValidator
{
	public function isValid( $data ) : bool;
}
