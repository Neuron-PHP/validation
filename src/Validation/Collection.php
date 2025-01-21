<?php

namespace Neuron\Validation;

/**
 * Allows multiple validators to be chained in one item.
 */
class Collection extends Base implements ICollection
{
	private array $_Validators = [];
	private $_Failed;

	protected function validate( $Data ) : bool
	{
		$this->_Failed = [];

		array_walk( $this->_Validators, [ $this, 'validateItem' ], $Data );

		return count( $this->_Failed ) > 0 ? false : true;
	}


	public function validateItem( $Validator, $Name, $Data )
	{
		if( !$Validator->isValid( $Data ) )
		{
			$this->_Failed[] = $Name;
		}
	}

	/**
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
	 * @return mixed
	 *
	 * Returns the list of failed validations.
	 */
	public function getViolations() : array
	{
		return $this->_Failed;
	}
}
