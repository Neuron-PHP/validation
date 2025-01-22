<?php

namespace Neuron\Validation;

/**
 * Requires a valid phone number format nnn-nnn-nnnn
 */
class IsPhoneNumber extends Base
{
	const US            = 10;
	const INTERNATIONAL = 20;

	const US_PATTERN            = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
	const INTERNATIONAL_PATTERN = "/^\+(?:[0-9] ?){6,14}[0-9]$/";

	public $_Type;

	public function __construct( int $Type = self::US )
	{
		$this->_Type = $Type;

		return parent::__construct();
	}

	/**
	 * @return int
	 */
	public function getType(): int
	{
		return $this->_Type;
	}

	/**
	 * @param int $Type
	 * @return IsPhoneNumber
	 */
	public function setType( int $Type ): IsPhoneNumber
	{
		$this->_Type = $Type;
		return $this;
	}

	/**
	 * @param mixed $Value
	 * @return bool
	 */
	public function validate( mixed $Value ) : bool
	{
		if( $this->getType() == self::INTERNATIONAL )
		{
			return preg_match( self::INTERNATIONAL_PATTERN, $Value ) == 1;
		}

		return preg_match( self::US_PATTERN, $Value ) == 1;
	}
}
