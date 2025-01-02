<?php

namespace Neuron\Validation;

/**
 * Requires a valid url format.
 */
class Url extends Base
{
	protected function validate( $url ) : bool
	{
		return (bool)filter_var( $url, FILTER_VALIDATE_URL );
	}
}
