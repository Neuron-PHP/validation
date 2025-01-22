<?php
/**
 * Created by PhpStorm.
 * User: lee
 * Date: 7/27/16
 * IsTime: 6:43 PM
 */

namespace Neuron\Validation;

use Neuron\Data\Object\DateRange;

/**
 * Requires a date within a specified range.
 */
class IsDateWithinRange extends IsDate
{
	private DateRange $_Range;

	public function __construct( DateRange $Range )
	{
		$this->setRange( $Range );
		parent::__construct();
	}

	/**
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		if( !parent::validate( $Value ) )
		{
			return false;
		}

		$startTS = strtotime( $this->_Range->Start );
		$endTS   = strtotime( $this->_Range->End );
		$dateTS  = strtotime( $Value );

		return ( $dateTS >= $startTS ) && ( $dateTS <= $endTS );
	}

	/**
	 * @param DateRange $Range
	 * @return $this
	 */
	public function setRange( DateRange $Range ) : IValidator
	{
		$this->_Range = $Range;

		return $this;
	}

	/**
	 * @return DateRange
	 */
	public function getRange() : DateRange
	{
		return $this->_Range;
	}
}
