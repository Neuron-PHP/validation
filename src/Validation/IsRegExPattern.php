<?php

namespace Neuron\Validation;

class IsRegExPattern extends Base
{
	private string $_pattern;

	public function __construct( $pattern )
	{
		$this->_pattern = $pattern;
		parent::__construct();
	}

	/**
	 * Returns the regex pattern.
	 * @return string
	 */
	public function getPattern(): string
	{
		return $this->_pattern;
	}

	/**
	 * Sets the regex pattern.
	 * @param string $pattern
	 * @return void
	 */
	public function setPattern( string $pattern ): void
	{
		$this->_pattern = $pattern;
	}

	/**
	 * @param $value
	 * @return bool
	 */
	protected function validate( $value ): bool
	{
		return preg_match( $this->_pattern, $value ) === 1;
	}
}
