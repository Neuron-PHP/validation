<?php

namespace Neuron\Validation;

/**
 * Allows multiple validators to be chained in one item.
 */
class Collection extends Base implements ICollection
{
	private array $_validators = [];
	private array $_failed = [];

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function validate( mixed $value ) : bool
	{
		$this->_failed = [];

		array_walk( $this->_validators, [ $this, 'validateItem' ], $value );

		return !count( $this->_failed ) > 0;
	}

	/**
	 * Validate an individual item by name.
	 * @param IValidator $validator
	 * @param string $name
	 * @param mixed $data
	 * @return void
	 */
	public function validateItem( IValidator $validator, string $name, mixed $data ): void
	{
		if( !$validator->isValid( $data ) )
		{
			$this->_failed[] = $name;
		}
	}

	/**
	 * Adds a named validator to the collection.
	 * @param string $name
	 * @param IValidator $validator
	 * @return $this
	 *
	 * Add a validator to the collection.
	 */
	public function add( string $name, IValidator $validator ) : ICollection
	{
		$this->_validators[ $name ] = $validator;

		return $this;
	}

	/**
	 * Gets a validator by name.
	 * @param string $name
	 * @return IValidator|null
	 */
	public function get( string $name ) : ?IValidator
	{
		if( !array_key_exists( $name, $this->_validators ) )
		{
			return null;
		}

		return $this->_validators[ $name ];
	}

	/**
	 * Removes a validator by name.
	 * @param string $name
	 * @return bool
	 */
	public function remove( string $name ): bool
	{
		if( !array_key_exists( $name, $this->_validators ) )
		{
			return false;
		}

		unset( $this->_validators[ $name ] );

		return true;
	}

	/**
	 * Returns the list of failed validations.
	 * @return mixed
	 *
	 */
	public function getViolations() : array
	{
		return $this->_failed;
	}
}
