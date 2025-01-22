<?php

namespace Neuron\Validation;

/**
 * Requires time to be in a specific format. Defaults to g:i:s A
 */
class IsTime extends Base
{
	private string $_Format = 'g:i:s A';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		$Time = \DateTime::createFromFormat( $this->_Format, $Value );
		return $Time && $Time->format( $this->_Format ) == $Value;
	}

	/**
	 * @param string $Format
	 * @return void
	 */
	public function setFormat( string $Format ): void
	{
		$this->_Format = $Format;
	}

	/**
	 * @return string
	 */
	public function getFormat(): string
	{
		return $this->_Format;
	}
}
