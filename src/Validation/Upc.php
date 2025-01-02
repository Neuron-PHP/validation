<?php

namespace Neuron\Validation;

class Upc extends Base
{
	protected function validate($upc) : bool
	{
		// validate upc code
		if (preg_match('/^[0-9]{12}$/', $upc))
		{
			$check = 0;
			for ($i = 0; $i < 11; $i += 2) {
				$check += $upc[$i];
			}
			$check *= 3;
			for ($i = 1; $i < 11; $i += 2) {
				$check += $upc[$i];
			}
			return ($upc[11] == ((10 - ($check % 10)) % 10));
		}
		return false;
	}
}
