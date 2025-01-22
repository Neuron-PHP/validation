<?php

namespace Neuron\Validation;

class IsRegExPattern extends Base
{
	private string $_Pattern;

	public function __construct( $Pattern )
	{
		$this->_Pattern = $Pattern;
		parent::__construct();
	}

	/**
	 * Returns the regex pattern.
	 * @return string
	 */
	public function getPattern(): string
	{
		return $this->_Pattern;
	}

	/**
	 * Sets the regex pattern.
	 * @param string $Pattern
	 * @return void
	 */
	public function setPattern( string $Pattern ): void
	{
		$this->_Pattern = $Pattern;
	}

	/**
	 * @param $Value
	 * @return bool
	 */
	protected function validate( $Value ): bool
	{
		return preg_match( $this->_Pattern, $Value ) === 1;
	}
}
