<?php

namespace Neuron\Validation;

class IsStringLength extends Base
{
	private int $_minLength;
	private int $_maxLength;

	/**
	 * Constructor method to initialize the minimum and maximum lengths.
	 *
	 * @param int $min The minimum length.
	 * @param int $max The maximum length.
	 * @return void
	 */
	public function __construct( int $min, int $max )
	{
		parent::__construct();

		$this->_minLength = $min;
		$this->_maxLength = $max;
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		$length = strlen( $value );
		return $this->_minLength <= $length && $length <= $this->_maxLength;
	}
}
