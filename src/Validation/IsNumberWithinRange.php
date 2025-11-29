<?php

namespace Neuron\Validation;

use Neuron\Data;

/**
 * Requires a number to be within a specific range.
 */
class IsNumberWithinRange extends Base
{
	private Data\Objects\NumericRange $_range;

	public function __construct( Data\Objects\NumericRange $range )
	{
		$this->setRange( $range );

		parent::__construct();
	}

	/**
	 * @param Data\Objects\NumericRange $range
	 * @return $this
	 */
	public function setRange( Data\Objects\NumericRange $range ): static
	{
		$this->_range = $range;

		return $this;
	}

	/**
	 * @return Data\Objects\NumericRange
	 */
	public function getRange(): Data\Objects\NumericRange
	{
		return $this->_range;
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		return ( ( $value >= $this->_range->minimum ) && ( $value <= $this->_range->maximum ) );
	}
}
