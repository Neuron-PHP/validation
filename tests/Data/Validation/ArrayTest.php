<?php

class ArrayTest extends PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$dn = new \Neuron\Validation\ArrayData();

		$this->assertFalse( $dn->isValid( 1 ) );
	}

	public function testPass()
	{
		$dn = new \Neuron\Validation\ArrayData();

		$this->assertTrue( $dn->isValid(
				[
					1,
					2
				]
			)
		);
	}
}
