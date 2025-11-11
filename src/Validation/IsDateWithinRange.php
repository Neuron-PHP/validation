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
	private DateRange $_range;

	public function __construct( DateRange $range )
	{
		$this->setRange( $range );
		parent::__construct();
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		if( !parent::validate( $value ) )
		{
			return false;
		}

		$startTS = strtotime( $this->_range->Start );
		$endTS   = strtotime( $this->_range->End );
		$dateTS  = strtotime( $value );

		return ( $dateTS >= $startTS ) && ( $dateTS <= $endTS );
	}

	/**
	 * @param DateRange $range
	 * @return $this
	 */
	public function setRange( DateRange $range ) : IValidator
	{
		$this->_range = $range;

		return $this;
	}

	/**
	 * @return DateRange
	 */
	public function getRange() : DateRange
	{
		return $this->_range;
	}
}
