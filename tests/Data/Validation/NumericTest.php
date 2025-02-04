<?php
namespace Tests\Data\Validation;

use Neuron\Validation\IsNumeric;

class NumericTest extends \PHPUnit\Framework\TestCase
{
	protected $_Validator;
	
	protected function setUp() : void
	{
		parent::setUp();
		
		$this->_Validator = new IsNumeric();
	}

	public function testPass()
	{
		$this->assertTrue(
			$this->_Validator->isValid( 1 )
		);

		$this->assertTrue(
			$this->_Validator->isValid( '1' )
		);

		$this->assertTrue(
			$this->_Validator->isValid( 1.25 )
		);

		$this->assertTrue(
			$this->_Validator->isValid( '1.25' )
		);
	}
	
	public function testFail()
	{
		$this->assertFalse(
			$this->_Validator->isValid( '123abc' )
		);
	}
}
