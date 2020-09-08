<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Helpers\Postman;

use ZnSandbox\Sandbox\RestClient\Domain\Entities\BookmarkEntity;
use yii2rails\extension\common\helpers\StringHelper;
use yii2rails\extension\web\enums\HttpMethodEnum;
use yii2bundle\rest\domain\entities\RequestEntity;
use yii2bundle\rest\domain\helpers\MiscHelper;

class GeneratorHelper {
	
	private static $variableNames = [];
	
	public static function genRequest(BookmarkEntity $requestEntity) {
		$result['method'] = $requestEntity->getMethod();
		$result['header'] = $requestEntity->getHeader();
		$result['body'] = $requestEntity->getBody();
		$result['url'] = $requestEntity->getUri();
		$result['description'] = $requestEntity->getDescription();
		return $result;
	}
	
	public static function genEvent(string $preRequest = null, string $test = null) {
		$result = [];
		if($preRequest) {
			$result[] = [
				'listen' => 'prerequest',
				'script' => [
					'id' => StringHelper::genUuid(),
					'type' => 'text/javascript',
					'exec' => explode(PHP_EOL, trim($preRequest)),
				],
			];
		}
		if($test) {
			$result[] = [
				'listen' => 'test',
				'script' => [
					'id' => StringHelper::genUuid(),
					'type' => 'text/javascript',
					'exec' => explode(PHP_EOL, trim($test)),
				]
			];
		}
		return $result;
	}
	
	public static function genHeaders(RequestEntity $requestEntity) {
		$result = [];
		$headers = $requestEntity->headers;
		if($requestEntity->authorization) {
			$headers['Authorization'] = self::genVariable('token');
		}
        $headers['Time-Zone'] = self::genVariable('timezone');
        $headers['Language'] = self::genVariable('language');
		if($headers) {
			foreach($headers as $key => $value) {
				$result[] = [
					'key' => $key,
					'value' => $value,
				];
			}
		}
		return $result;
	}
	
	public static function genPostBody(RequestEntity $requestEntity) {
		$result = null;
		if(in_array($requestEntity->method, [HttpMethodEnum::POST, HttpMethodEnum::PUT]) && $requestEntity->data) {
			$body = [];
			foreach($requestEntity->data as $key => $value) {
				$body[] = [
					'key' => $key,
					'value' => $value,
					'description' => '',
					'type' => 'text',
				];
			}
			$result = [
				'mode' => 'urlencoded',
				'urlencoded' => $body,
			];
		}
		return $result;
	}
	
	public static function genUrl(RequestEntity $requestEntity) {
		$hostVariable = self::genVariable('host');
		$url = [
			'raw' => $hostVariable . '/' . $requestEntity->uri,
			'host' => [
				$hostVariable,
			],
			'path' => explode('/', $requestEntity->uri),
		];
		if($requestEntity->method == HttpMethodEnum::GET && $requestEntity->data) {
			$query = [];
			foreach($requestEntity->data as $key => $value) {
				$query[] = [
					'key' => $key,
					'value' => $value,
				];
			}
			$url['query'] = $query;
		}
		return $url;
	}
	
	public static function genVariable($name) {
		$scope = self::genPureVariable($name);
		$result = '{{' . $scope . '}}';
		return $result;
	}
	
	public static function genPureVariable($name) {
		$scope = MiscHelper::collectionNameFormatId() . '-' . $name;
		self::$variableNames[] = $scope;
		return $scope;
	}
}