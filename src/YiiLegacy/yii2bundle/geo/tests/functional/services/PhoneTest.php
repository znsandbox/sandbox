<?php

namespace tests\functional\services;

use yii\web\NotFoundHttpException;
use yii2tool\test\helpers\DataHelper;
use yii2tool\test\Test\Unit;

class PhoneTest extends Unit {
	
	const PACKAGE = 'yii2bundle/yii2-geo';
	
	public function testAll() {
		$collection = \App::$domain->geo->phone->all();
		
		$expect = DataHelper::loadForTest(self::PACKAGE, __METHOD__, $collection);
		$this->tester->assertCollection($expect, $collection, true);
	}
	
	public function testOneByPhoneUz() {
		$phone = '998909472730';
		$phoneEntity = \App::$domain->geo->phone->oneByPhone($phone);
		
		$expect = DataHelper::loadForTest(self::PACKAGE, __METHOD__, $phoneEntity);
		$this->tester->assertEntity($expect, $phoneEntity, true);
	}
	
	public function testOneByPhoneKz() {
		$phone = '77021234567';
		$phoneEntity = \App::$domain->geo->phone->oneByPhone($phone);
		
		$expect = DataHelper::loadForTest(self::PACKAGE, __METHOD__, $phoneEntity);
		$this->tester->assertEntity($expect, $phoneEntity, true);
	}
	
	public function testOneByPhoneNotFound() {
		$phone = '99890947';
		
		try {
			$phoneEntity = \App::$domain->geo->phone->oneByPhone($phone);
			$this->tester->assertBad($phoneEntity);
		} catch(NotFoundHttpException $e) {
			$this->tester->assertNice();
		}
	}
	
	public function testParseUz() {
		$phone = '998909472730';
		$phoneEntity = \App::$domain->geo->phone->parse($phone);
		
		$expect = DataHelper::loadForTest(self::PACKAGE, __METHOD__, $phoneEntity);
		$this->tester->assertEntity($expect, $phoneEntity, true);
	}
	
	public function testParseKz() {
		$phone = '77021234567';
		$phoneEntity = \App::$domain->geo->phone->parse($phone);
		
		$expect = DataHelper::loadForTest(self::PACKAGE, __METHOD__, $phoneEntity);
		$this->tester->assertEntity($expect, $phoneEntity, true);
	}
	
	public function testParseFail() {
		$phone = '99890947';
		
		try {
			$phoneEntity = \App::$domain->geo->phone->parse($phone);
			$this->tester->assertBad($phoneEntity);
		} catch(NotFoundHttpException $e) {
			$this->tester->assertNice();
		}
	}
	
	public function testFormatUz() {
		$phone = '998909472730';
		$actual = \App::$domain->geo->phone->format($phone);
		
		$this->tester->assertEquals('+998 (90) 947 27 30', $actual);
	}
	
	public function testFormatKz() {
		$phone = '77021234567';
		$actual = \App::$domain->geo->phone->format($phone);
		
		$this->tester->assertEquals('+7 (702) 123 45 67', $actual);
	}
	
	public function testFormatFail() {
		$phone = '99890947';
		
		try {
			$phoneEntity = \App::$domain->geo->phone->format($phone);
			$this->tester->assertBad($phoneEntity);
		} catch(NotFoundHttpException $e) {
			$this->tester->assertNice();
		}
	}
}
