<?php
class StringTest extends PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$dn = new \Neuron\Validation\StringData();

		$this->assertFalse( $dn->isValid( 1 ) );
	}

	public function testPass()
	{
		$dn = new \Neuron\Validation\StringData();

		$this->assertTrue( $dn->isValid( 'test@example.org' ) );
	}
}
