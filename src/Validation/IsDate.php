<?php

namespace Neuron\Validation;

/**
 * Requires a date with a specific format. Defaults to Y-m-d
 */
class IsDate extends Base
{
	private string $_format = 'Y-m-d';

	/**
	 * @param $format - Specify the date format to validate to. Defaults to Y-m-d
	 * @return $this
	 */
	public function setFormat( string $format ) : IValidator
	{
		$this->_format = $format;

		return $this;
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		return date( $this->_format, strtotime( $value ) ) == $value;
	}
}
