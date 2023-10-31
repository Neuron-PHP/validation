<?php

namespace Data\Validation;

use Neuron\Validation\Json;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
	public function testJson()
	{
		$Json = new Json();

		$this->assertTrue(
			$Json->isValid(
				json_encode(
					[
						'one'   => 1,
						'two'   => 2,
						'three' => 3
					]
				)
			)
		);

		$this->assertFalse(
			$Json->isValid(
				'invalidjson'
			)
		);
	}
}
