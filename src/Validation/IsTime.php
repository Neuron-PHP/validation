<?php

namespace Neuron\Validation;

/**
 * Requires time to be in a specific format. Defaults to g:i:s A
 */
class IsTime extends Base
{
	private string $_format = 'g:i:s A';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		$time = \DateTime::createFromFormat( $this->_format, $value );
		return $time && $time->format( $this->_format ) == $value;
	}

	/**
	 * @param string $format
	 * @return void
	 */
	public function setFormat( string $format ): void
	{
		$this->_format = $format;
	}

	/**
	 * @return string
	 */
	public function getFormat(): string
	{
		return $this->_format;
	}
}
