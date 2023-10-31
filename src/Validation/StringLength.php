<?php

namespace Neuron\Validation;

class StringLength extends Base
{
	private $_MaxLength;

	public function __construct( int $MaxLength )
	{
		parent::__construct();

		$this->_MaxLength = $MaxLength;
	}

	protected function validate( $Data ) : bool
	{
		return strlen( $Data ) < $this->_MaxLength;
	}
}
