<?php

namespace Neuron\Validation;

use Neuron\Data;

/**
 * Requires a number to be within a specific range.
 */
class IsNumberWithinRange extends Base
{
	private Data\Object\NumericRange $_range;

	public function __construct( Data\Object\NumericRange $range )
	{
		$this->setRange( $range );

		parent::__construct();
	}

	/**
	 * @param Data\Object\NumericRange $range
	 * @return $this
	 */
	public function setRange( Data\Object\NumericRange $range ): static
	{
		$this->_range = $range;

		return $this;
	}

	/**
	 * @return Data\Object\NumericRange
	 */
	public function getRange(): Data\Object\NumericRange
	{
		return $this->_range;
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		return ( ( $value >= $this->_range->Minimum ) && ( $value <= $this->_range->Maximum ) );
	}
}
