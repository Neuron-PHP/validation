<?php

namespace Neuron\Validation;

use Neuron\Data;

/**
 * Requires a number to be within a specific range.
 */
class IsNumberWithinRange extends Base
{
	private Data\Object\NumericRange $_Range;

	public function __construct( Data\Object\NumericRange $Range )
	{
		$this->setRange( $Range );

		parent::__construct();
	}

	/**
	 * @param Data\Object\NumericRange $Range
	 * @return $this
	 */
	public function setRange( Data\Object\NumericRange $Range ): static
	{
		$this->_Range = $Range;

		return $this;
	}

	/**
	 * @return Data\Object\NumericRange
	 */
	public function getRange(): Data\Object\NumericRange
	{
		return $this->_Range;
	}

	/**
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		return ( ( $Value >= $this->_Range->Minimum ) && ( $Value <= $this->_Range->Maximum ) );
	}
}
