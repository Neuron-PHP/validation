<?php

namespace Neuron\Validation;

trait Policy
{
	private array $_rules;

	/**
	 * @param $name
	 * @param IValidator $validator
	 * @return static
	 */
	public function addRule( $name, IValidator $validator ) : static
	{
		$this->_rules[ $name ] = $validator;

		return $this;
	}

	/**
	 * @param $name
	 * @param $value
	 * @return mixed
	 */
	public function isRuleValid( $name, $value ) : bool
	{
		return $this->_rules[ $name ]->isValid( $value );
	}
}
