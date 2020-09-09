<?php

namespace yii2rails\app\domain;

use yii2rails\domain\enums\Driver;

/**
 * Class Domain
 *
 * @package yii2rails\app\domain
 *
 * @property \yii2rails\app\domain\services\ModeService $mode
 * @property \yii2rails\app\domain\services\UrlService $url
 * @property \yii2rails\app\domain\services\RemoteService $remote
 * @property \yii2rails\app\domain\services\ConnectionService $connection
 * @property \yii2rails\app\domain\services\CookieService $cookie
 */
class Domain extends \yii2rails\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
				'mode' => Driver::DISC,
				'url' => Driver::DISC,
				'remote' => Driver::DISC,
				'connection' => Driver::DISC,
				'cookie' => Driver::DISC,
			],
			'services' => [
				'mode',
				'url',
				'remote',
				'connection',
				'cookie',
			],
		];
	}
	
}