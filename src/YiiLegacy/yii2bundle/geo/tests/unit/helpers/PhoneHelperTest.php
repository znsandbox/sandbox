<?php

namespace tests\unit\helpers;

use yii2bundle\geo\domain\helpers\PhoneHelper;
use yii2tool\test\Test\Unit;

class PhoneHelperTest extends Unit {
	
	public function testClean() {
		$expect = '998909472730';
		
		$actual = PhoneHelper::clean('998909472730');
		$this->tester->assertEquals($expect, $actual);
		
		$actual = PhoneHelper::clean('--99--890--94---727---30');
		$this->tester->assertEquals($expect, $actual);
		
		$actual = PhoneHelper::clean('+++--99--89(0--94---72)7---)30)');
		$this->tester->assertEquals($expect, $actual);
		
		$actual = PhoneHelper::clean('+998909472730');
		$this->tester->assertEquals($expect, $actual);
	}
	
	public function testFormat() {
		$phone = '998909472730';
		
		$actual = PhoneHelper::formatByMask($phone, '+999 (99) 999 99 99');
		$this->tester->assertEquals('+998 (90) 947 27 30', $actual);
		
		$actual = PhoneHelper::formatByMask('+998(90)947-27-30', '+999 (99) 999 99 99');
		$this->tester->assertEquals('+998 (90) 947 27 30', $actual);
		
		$actual = PhoneHelper::formatByMask($phone, '+999 (99) 999-99-99');
		$this->tester->assertEquals('+998 (90) 947-27-30', $actual);
		
		$actual = PhoneHelper::formatByMask($phone, '+999 99 999 99 99');
		$this->tester->assertEquals('+998 90 947 27 30', $actual);
		
		$actual = PhoneHelper::formatByMask($phone, '999 99 999 99 99');
		$this->tester->assertEquals('998 90 947 27 30', $actual);
	}
	
	public function testMatch() {
		$actual = PhoneHelper::matchPhone('998909472730', '(998)(9\d)(\d{7})');
		$this->tester->assertEquals([
			'id' => '998909472730',
			'country' => 998,
			'provider' => 90,
			'client' => 9472730,
		], $actual->toArray());
		
		$actual = PhoneHelper::matchPhone('77021234567', '(7)(7\\d{2})(\\d{7})');
		$this->tester->assertEquals([
			'id' => '77021234567',
			'country' => 7,
			'provider' => 702,
			'client' => 1234567,
		], $actual->toArray());
		
		$actual = PhoneHelper::matchPhone('+7(702)123-45-67', '(7)(7\\d{2})(\\d{7})');
		$this->tester->assertEquals([
			'id' => '77021234567',
			'country' => 7,
			'provider' => 702,
			'client' => 1234567,
		], $actual->toArray());
	}
}
