<?php
namespace Tests\Data\Validation;

class PhoneNumberTest extends \PHPUnit\Framework\TestCase
{
	public function testFail()
	{
		$Phone = new \Neuron\Validation\PhoneNumber();

		$this->assertFalse( $Phone->isValid( '5541234x' ) );
	}

	public function testPass()
	{
		$Phone = new \Neuron\Validation\PhoneNumber();

		$this->assertTrue( $Phone->isValid( '941-248-3500' ) );
	}

	public function testIntlFail()
	{
		$Phone = new \Neuron\Validation\PhoneNumber();
		$Phone->setType( $Phone::INTERNATIONAL );

		$this->assertFalse( $Phone->isValid( '5541234x' ) );
	}

	public function testIntlPass()
	{
		$Phone = new \Neuron\Validation\PhoneNumber();
		$Phone->setType( $Phone::INTERNATIONAL );

		$this->assertTrue( $Phone->isValid( '+49 89 636 48098' ) );
	}
}
