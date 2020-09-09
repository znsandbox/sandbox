<?php

namespace yii2rails\extension\core\domain\helpers;

use Yii;
use App;
use yii\base\InvalidConfigException;
use yii2rails\App\domain\helpers\EnvService;
use yii2rails\extension\web\enums\HttpHeaderEnum;
use yii2bundle\account\domain\v3\helpers\AuthHelper;

class CoreHelper {
	
	public static function defaultApiVersionNumber($default = null) {
		$version = EnvService::get('servers.core.defaultVersion', $default);
		if(empty($version)) {
			throw new InvalidConfigException('Undefined version in ' . self::class);
		}
		return $version;
	}

    public static function defaultApiVersionSting($default = null) {
        return 'v' . self::defaultApiVersionNumber($default);
    }
	
	public static function forgeUrl($version, $point = null) {
		$url = CoreHelper::getUrl($version);
		$point = trim($point, SL);
		if(!empty($point)) {
			$url .= SL . $point;
		}
		return $url;
	}
	
	public static function getUrl($version) {
		$url = self::getCoreDomain();
		if(YII_ENV_TEST) {
			$url .= SL . 'index-test.php';
		}
		$url .= SL . 'v' . $version;
		return $url;
	}
	
	public static function getHeaders() {
		$tokenDto = AuthHelper::getTokenDto();
		if($tokenDto) {
			$headers[HttpHeaderEnum::AUTHORIZATION] = AuthHelper::getTokenString();
		}
		if(isset(App::$domain->partner) && !App::$domain->partner->auth->isAsCore()) {
            $token = App::$domain->partner->auth->forgeSelfToken();
            if($token) {
                $headers['Authorization-partner'] = 'jwt ' . $token;
            }
        }
		$headers[HttpHeaderEnum::LANGUAGE] = Yii::$app->language;
		$headers[HttpHeaderEnum::TIME_ZONE] = Yii::$app->timeZone;
		return $headers;
	}
	
	private static function getCoreDomain() {
		$domain = EnvService::get('servers.core.host');
		$domain = rtrim($domain, SL);
		return $domain;
	}
	
}
