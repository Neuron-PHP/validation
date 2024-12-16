<?php
namespace Tests\Data\Validation;

class IntegerTest extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$Integer = new \Neuron\Validation\Integer();

		$this->assertFalse( $Integer->isValid( 'non int' ) );
	}

	public function testPass()
	{
		$Integer = new \Neuron\Validation\Integer();

		$this->assertTrue( $Integer->isValid( 1 ) );
	}
}
