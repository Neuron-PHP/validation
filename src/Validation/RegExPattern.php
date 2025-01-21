<?php

namespace Neuron\Validation;

class RegExPattern extends Base
{
	private string $_Pattern;

	public function __construct( $Pattern )
	{
		$this->_Pattern = $Pattern;
	}

	protected function validate( $data ): bool
	{
		return preg_match( $this->_Pattern, $data ) === 1;
	}
}
