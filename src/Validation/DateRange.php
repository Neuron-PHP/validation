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
		// validate the format of start
		if( !parent::validate( $Range->Start ) )
		{
			return false;
		}

		// validate the format of end
		if( !parent::validate( $Range->End ) )
		{
			return false;
		}

		$startTS = strtotime( $Range->Start );
		$endTS   = strtotime( $Range->End );

		return ( $startTS < $endTS );
	}
}
