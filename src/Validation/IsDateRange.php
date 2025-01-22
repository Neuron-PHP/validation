<?php

namespace Neuron\Validation;

/**
 * Validates a DateRange data object.
 * @see IsDate
 */
class IsDateRange extends IsDate
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
		$startTS = strtotime( $Value->Start );
		$endTS   = strtotime( $Value->End );

		return ( $startTS < $endTS );
	}
}
