<?php

namespace Neuron\Validation;

/**
 * Allows multiple validators to be chained in one item.
 */
class Collection extends Base implements ICollection
{
	private array $_Validators = [];
	private array $_Failed = [];

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param mixed $Value
	 * @return bool
	 */
	protected function validate( mixed $Value ) : bool
	{
		$this->_Failed = [];

		array_walk( $this->_Validators, [ $this, 'validateItem' ], $Value );

		return !count( $this->_Failed ) > 0;
	}

	/**
	 * Validate an individual item by name.
	 * @param IValidator $Validator
	 * @param string $Name
	 * @param mixed $Data
	 * @return void
	 */
	public function validateItem( IValidator $Validator, string $Name, mixed $Data ): void
	{
		if( !$Validator->isValid( $Data ) )
		{
			$this->_Failed[] = $Name;
		}
	}

	/**
	 * Adds a named validator to the collection.
	 * @param string $Name
	 * @param IValidator $Validator
	 * @return $this
	 *
	 * Add a validator to the collection.
	 */
	public function add( string $Name, IValidator $Validator ) : ICollection
	{
		$this->_Validators[ $Name ] = $Validator;

		return $this;
	}

	/**
	 * Gets a validator by name.
	 * @param string $Name
	 * @return IValidator|null
	 */
	public function get( string $Name ) : ?IValidator
	{
		if( !array_key_exists( $Name, $this->_Validators ) )
		{
			return null;
		}

		return $this->_Validators[ $Name ];
	}

	/**
	 * Removes a validator by name.
	 * @param string $Name
	 * @return bool
	 */
	public function remove( string $Name ): bool
	{
		if( !array_key_exists( $Name, $this->_Validators ) )
		{
			return false;
		}

		unset( $this->_Validators[ $Name ] );

		return true;
	}

	/**
	 * Returns the list of failed validations.
	 * @return mixed
	 *
	 */
	public function getViolations() : array
	{
		return $this->_Failed;
	}
}
