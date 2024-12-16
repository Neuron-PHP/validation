<?php
namespace Tests\Data\Validation;

class NameTest extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$Name = new \Neuron\Validation\Name();

		$this->assertFalse( $Name->isValid( 'Monkey311' ) );
	}

	public function testPass()
	{
		$Name = new \Neuron\Validation\Name();

		$this->assertTrue( $Name->isValid( 'Lee Jones' ) );
		$this->assertTrue( $Name->isValid( 'Dr. Indian Jones' ) );
		$this->assertTrue( $Name->isValid( 'Dr. Indian Jones, PHD' ) );
	}
}
