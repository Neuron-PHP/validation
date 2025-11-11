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
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		$startTS = strtotime( $value->Start );
		$endTS   = strtotime( $value->End );

		return ( $startTS < $endTS );
	}
}
