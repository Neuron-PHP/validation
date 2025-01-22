<?php
namespace Tests\Data\Validation;

class StringTest extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$dn = new \Neuron\Validation\IsString();

		$this->assertFalse( $dn->isValid( 1 ) );
	}

	public function testPass()
	{
		$dn = new \Neuron\Validation\IsString();

		$this->assertTrue( $dn->isValid( 'test@example.org' ) );
	}
}
