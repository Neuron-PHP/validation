<?php

namespace Neuron\Validation;

/**
 * Requires a boolean.
 */
class IsBoolean extends Base
{
	private $_Loose;

	/**
	 * @param bool $Loose
	 */
	public function __construct( bool $Loose = false )
	{
		$this->_Loose = $Loose;
		parent::__construct();
	}

	protected function validate(  mixed $Value ) : bool
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
