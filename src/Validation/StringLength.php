<?php

namespace Neuron\Validation;

class StringLength extends Base
{
	private int $_MinLength;
	private int $_MaxLength;

	public function __construct( $Min, $Max )
	{
		parent::__construct();

		$this->_MinLength = $Min;
		$this->_MaxLength = $Max;
	}

	protected function validate( $Data ) : bool
	{
		$Length = strlen( $Data );
		return $this->_MinLength <= $Length && $Length <= $this->_MaxLength;
	}
}
