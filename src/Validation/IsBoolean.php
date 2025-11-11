<?php

namespace Neuron\Validation;

/**
 * Requires a boolean.
 */
class IsBoolean extends Base
{
	private $_loose;

	/**
	 * @param bool $loose
	 */
	public function __construct( bool $loose = false )
	{
		$this->_loose = $loose;
		parent::__construct();
	}

	protected function validate(  mixed $value ) : bool
	{
		$result = false;

		if( $this->_loose )
		{
			if( $value === 0 || $value === 1 )
			{
				$result = true;
			}

			if( $value === '0' || $value == '1' )
			{
				$result = true;
			}

			$value = strtolower( $value );

			if( $value === 'false' || $value == 'true' || $value == 'on' || $value == 'yes' || $value == 'no' || $value == 'off' )
			{
				$result = true;
			}
		}
		else
		{
			$result = is_bool( $value );
		}

		return $result;
	}
}
