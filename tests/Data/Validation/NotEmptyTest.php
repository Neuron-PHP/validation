<?php
namespace Tests\Data\Validation;

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 8/3/16
 * IsTime: 11:11 AM
 */
class NotEmptyTest extends \PHPUnit\Framework\TestCase
{
	public function testNotEmpty()
	{
		$Validator = new \Neuron\Validation\IsNotEmpty();

		$this->assertTrue( $Validator->isValid( 'test' ) );
		$this->assertFalse( $Validator->isValid( '' ) );
		$this->assertFalse( $Validator->isValid( 0 ) );
		$this->assertFalse( $Validator->isValid( false ) );
		$this->assertFalse( $Validator->isValid( null ) );
	}
}
