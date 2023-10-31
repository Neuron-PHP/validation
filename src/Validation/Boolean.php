<?php

namespace Neuron\Validation;

/**
 * Requires a boolean.
 */
class Boolean extends Base
{
	private $_Loose;

	public function __construct( $Loose = false )
	{
		$this->_Loose = $Loose;
	}

	protected function validate( $Value ) : bool
	{
		$Result = false;

		if( $this->_Loose )
		{
			if( $Value === 0 || $Value === 1 )
			{
				$Result = true;
			}

			if( $Value === '0' || $Value == '1' )
			{
				$Result = true;
			}

			$Value = strtolower( $Value );

			if( $Value === 'false' || $Value == 'true' || $Value == 'on' || $Value == 'yes' || $Value == 'no' || $Value == 'off' )
			{
				$Result = true;
			}
		}
		else
		{
			$Result = is_bool( $Value );
		}

		return $Result;
	}
}
