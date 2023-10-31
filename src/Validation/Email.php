<?php

namespace Neuron\Validation;

/**
 * Requires a valid email address format.
 */
class Email extends Base
{
	protected function validate( $email ) : bool
	{
		return filter_var( $email, FILTER_VALIDATE_EMAIL ) ? true : false;
	}
}
