<?php
namespace Tests\Data\Validation;

use Neuron\Validation\IsJson;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
	public function testJson()
	{
		$Json = new IsJson();

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

		$this->assertFalse(
			$Json->isValid(
				1
			)
		);

	}
}
