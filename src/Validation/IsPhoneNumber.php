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

	public $_type;

	public function __construct( int $type = self::US )
	{
		$this->_type = $type;

		return parent::__construct();
	}

	/**
	 * @return int
	 */
	public function getType(): int
	{
		return $this->_type;
	}

	/**
	 * @param int $type
	 * @return IsPhoneNumber
	 */
	public function setType( int $type ): IsPhoneNumber
	{
		$this->_type = $type;
		return $this;
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	public function validate( mixed $value ) : bool
	{
		if( $this->getType() == self::INTERNATIONAL )
		{
			return preg_match( self::INTERNATIONAL_PATTERN, $value ) == 1;
		}

		return preg_match( self::US_PATTERN, $value ) == 1;
	}
}
