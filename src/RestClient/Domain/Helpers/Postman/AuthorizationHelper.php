<?php

namespace PhpLab\Sandbox\RestClient\Domain\Helpers\Postman;

use PhpLab\Sandbox\RestClient\Domain\Entities\BookmarkEntity;
use Yii;
use yii2rails\extension\web\enums\HttpMethodEnum;
use yii2bundle\rest\domain\entities\RequestEntity;
use yii2bundle\account\domain\v3\entities\TestEntity;

class AuthorizationHelper {
	
	public static function genAuthCollection() {
		$items = [];
		/** @var TestEntity[] $loginList */
		$loginList = \App::$domain->account->test->all();
		foreach($loginList as $testEntity) {
			$requestEntity = self::genAuthRequestEntity($testEntity);
			$request = GeneratorHelper::genRequest($requestEntity);
			$items[] = [
				'name' => $requestEntity->getUri() . ($request['description'] ? " ({$request['description']})" : ''),
				'event' => GeneratorHelper::genEvent(null, self::genAuthScript()),
				'request' => $request,
				'response' => [],
			];
		}
		return $items;
	}
	
	private static function genAuthRequestEntity($testEntity) : BookmarkEntity {
		$requestEntity = new BookmarkEntity;
		$requestEntity->setUri('auth');
		$requestEntity->setMethod(HttpMethodEnum::POST);
		$requestEntity->data = [
			'login' => $testEntity->login,
			'password' => 'Wwwqqq111',
		];
		$requestEntity->setDescription("by {$testEntity->login}");
		return $requestEntity;
	}
	
	private static function genAuthScript() {
		$variableName = GeneratorHelper::genPureVariable('token');
		$code = '
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

var authData = JSON.parse(responseBody);
pm.globals.set("' . $variableName . '", authData.token);';
		return $code;
	}
}