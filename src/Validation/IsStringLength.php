<?php

namespace Neuron\Validation;

class IsStringLength extends Base
{
	private int $_MinLength;
	private int $_MaxLength;

	/**
	 * Constructor method to initialize the minimum and maximum lengths.
	 *
	 * @param int $Min The minimum length.
	 * @param int $Max The maximum length.
	 * @return void
	 */
	public function __construct( int $Min, int $Max )
	{
		parent::__construct();

		$this->_MinLength = $Min;
		$this->_MaxLength = $Max;
	}

	/**
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		$Length = strlen( $Value );
		return $this->_MinLength <= $Length && $Length <= $this->_MaxLength;
	}
}
