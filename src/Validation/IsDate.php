<?php

namespace Neuron\Validation;

/**
 * Requires a date with a specific format. Defaults to Y-m-d
 */
class IsDate extends Base
{
	private string $_Format = 'Y-m-d';

	/**
	 * @param $Format - Specify the date format to validate to. Defaults to Y-m-d
	 * @return $this
	 */
	public function setFormat( string $Format ) : IValidator
	{
		$this->_Format = $Format;

		return $this;
	}

	/**
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		return date( $this->_Format, strtotime( $Value ) ) == $Value;
	}
}
