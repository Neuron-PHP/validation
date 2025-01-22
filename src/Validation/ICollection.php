<?php
/**
 * Created by PhpStorm.
 * User: lee
 * Date: 6/24/18
 * IsTime: 7:39 AM
 */

namespace Neuron\Validation;

/**
 * Validation collection.
 */
interface ICollection extends IValidator
{
	/**
	 * @param string $Name
	 * @param IValidator $Validator
	 * @return $this
	 *
	 * Add a validator to the collection.
	 */
	public function add( string $Name, IValidator $Validator ) : ICollection;

	/**
	 * @param string $Name
	 * @return IValidator|null
	 */
	public function get( string $Name ) : ?IValidator;

	/**
	 * @param string $Name
	 * @return bool
	 */
	public function remove( string $Name ) : bool;

	/**
	 * @return mixed
	 *
	 * Returns the list of failed validations.
	 */
	public function getViolations(): array;
}
