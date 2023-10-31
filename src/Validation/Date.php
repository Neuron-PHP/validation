<?php

namespace Neuron\Validation;

/**
 * Requires a date with a specific format. Defaults to Y-m-d
 */
class Date extends Base
{
	private $_Format = 'Y-m-d';

	protected function validate( $CheckDate ) : bool
	{
		return date( $this->_Format, strtotime( $CheckDate) ) == $CheckDate;
	}

	/**
	 * @param $Format - Specify the date format to validate to. Defaults to Y-m-d
	 * @return $this
	 */

	public function setFormat( $Format )
	{
		$this->_Format = $Format;

		return $this;
	}
}
