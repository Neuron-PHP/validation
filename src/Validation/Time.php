<?php

namespace Neuron\Validation;

/**
 * Requires time to be in a specific format. Defaults to g:i:s A
 */
class Time extends Base
{
	private $_sFormat = 'g:i:s A';

	protected function validate( $CheckTime ) : bool
	{
		$Time = \DateTime::createFromFormat( $this->_sFormat, $CheckTime );
		return $Time && $Time->format( $this->_sFormat ) == $CheckTime;
	}

	/**
	 * @param $sFormat - Specify the date format to validate to. Defaults to g:i:s A
	 */

	public function setFormat( $sFormat )
	{
		$this->_sFormat = $sFormat;
	}
}
