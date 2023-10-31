<?php

namespace Neuron\Validation;

use Neuron\Data;

/**
 * Requires a number to be within a specific range.
 */
class NumberWithinRange extends Base
{
	private $_Range;

	protected function validate( $data ) : bool
	{
		return ( ( $data >= $this->_Range->Minimum ) && ( $data <= $this->_Range->Maximum ) );
	}

	public function setRange( Data\Object\NumericRange $Range )
	{
		$this->_Range = $Range;

		return $this;
	}
}
