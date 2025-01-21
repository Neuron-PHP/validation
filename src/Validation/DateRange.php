<?php

namespace Neuron\Validation;

/**
 * Validates a DateRange data object.
 * @see Date
 */
class DateRange extends Date
{
	protected function validate( $Range ) : bool
	{
		$startTS = strtotime( $Range->Start );
		$endTS   = strtotime( $Range->End );

		return ( $startTS < $endTS );
	}
}
