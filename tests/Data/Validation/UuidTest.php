<?php

namespace Tests\Data\Validation;

use Neuron\Validation\IsUuid;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 9/5/15
 * IsTime: 11:07 AM
 */
class UuidTest extends TestCase
{
	public function testFail()
	{
		$dn = new IsUuid();

		$this->assertFalse( $dn->isValid( 'this is a test' ) );
	}

	public function testPass()
	{
		$dn = new IsUuid();

		$this->assertTrue( $dn->isValid( 'f1085408-111f-40f1-b31a-d970cf0d4994' ) );
	}

}
