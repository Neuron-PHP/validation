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
	 * @param string $name
	 * @param IValidator $validator
	 * @return $this
	 *
	 * Add a validator to the collection.
	 */
	public function add( string $name, IValidator $validator ) : ICollection;

	/**
	 * @param string $name
	 * @return IValidator|null
	 */
	public function get( string $name ) : ?IValidator;

	/**
	 * @param string $name
	 * @return bool
	 */
	public function remove( string $name ) : bool;

	/**
	 * @return mixed
	 *
	 * Returns the list of failed validations.
	 */
	public function getViolations(): array;
}
