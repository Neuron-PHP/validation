<?php

namespace Neuron\Validation;

/**
 * Requires time to be in a specific format. Defaults to g:i:s A
 */
class Time extends Base
{
	private string $_Format = 'g:i:s A';

	protected function validate( $CheckTime ) : bool
	{
		$Time = \DateTime::createFromFormat( $this->_Format, $CheckTime );
		return $Time && $Time->format( $this->_Format ) == $CheckTime;
	}

	/**
	 * @param $sFormat - Specify the date format to validate to. Defaults to g:i:s A
	 */

	public function setFormat( $Format ): void
	{
		$this->_Format = $Format;
	}
}
