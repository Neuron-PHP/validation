<?php
namespace Tests\Data\Validation;

class PositiveTest extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$Positive = new \Neuron\Validation\Positive();

		$this->assertFalse( $Positive->isValid( -1 ) );
	}

	public function testPass()
	{
		$Positive = new \Neuron\Validation\Positive();

		$this->assertTrue( $Positive->isValid( 1 ) );
	}
}
