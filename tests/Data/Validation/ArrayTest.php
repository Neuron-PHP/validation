<?php
namespace Tests\Data\Validation;
class ArrayTest extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$dn = new \Neuron\Validation\IsArray();

		$this->assertFalse( $dn->isValid( 1 ) );
	}

	public function testPass()
	{
		$dn = new \Neuron\Validation\IsArray();

		$this->assertTrue( $dn->isValid(
				[
					1,
					2
				]
			)
		);
	}
}
