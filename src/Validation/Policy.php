<?php

namespace Neuron\Validation;

trait Policy
{
	private array $_Rules;

	/**
	 * @param $Name
	 * @param IValidator $Validator
	 * @return static
	 */
	public function addRule( $Name, IValidator $Validator ) : static
	{
		$this->_Rules[ $Name ] = $Validator;

		return $this;
	}

	/**
	 * @param $Name
	 * @param $Value
	 * @return mixed
	 */
	public function isRuleValid( $Name, $Value ) : bool
	{
		return $this->_Rules[ $Name ]->isValid( $Value );
	}
}
