<?php

namespace Neuron\Validation;

use Neuron\Validation\Base;

/**
 * Requires a valid UUID format. 
 */
class IsUuid extends Base
{

	/**
	 * @inheritDoc
	 */
	
	protected function validate( mixed $Value ): bool
	{
		return is_string( $Value ) && preg_match( '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $Value ) === 1;
	}
}
