<?php

namespace ZnSandbox\Sandbox\Error\Domain\Helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\HttpException;
use Exception;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;

class MessageHelper
{
	
	public static function get(Exception $exception) {
        $translate = self::getTranslate($exception);
	    if($exception instanceof UnprocessableEntityHttpException) {
            $translate['message'] = self::getUnprocessableEntityExceptionMessage($exception);
        }
		$translate = self::normalizeTranslate($translate, $exception);
		return $translate;
	}

    private static function getUnprocessableEntityExceptionMessage(Exception $exception) {
        $content = '<ul>';
        foreach ($exception->getErrors() as $error) {
            $content .= "<li>{$error['message']}</li>";
        }
        $content .= '<ul>';
        return $content;
    }

	private static function getExceptionCode(Exception $exception)
	{
		if ($exception instanceof HttpException) {
			return $exception->statusCode;
		}
		return $exception->getCode();
	}
	
	private static function getExceptionName(Exception $exception)
	{
		if ($exception instanceof HttpException) {
			$name = $exception->getName();
		} else {
			$name = I18Next::t('error', 'main.default_title');
		}
		if (YII_ENV_DEV && $code = self::getExceptionCode($exception)) {
			$name .= " (#$code)";
		}
		return $name;
	}
	
	private static function getTranslateByClassName(Exception $exception) {
		$className = get_class($exception);
		$translate = I18Next::t('error', 'exceptions.' . $className);
		if(is_array($translate)) {
			return $translate;
		}
		return null;
	}
	
	private static function getTranslateByStatusCode(Exception $exception) {
		$translateKey = self::getExceptionCode($exception) ?: self::getExceptionName($exception);
		$translateKey = self::normalizeTranslateKey($translateKey);
		$translate = I18Next::t('error', 'main.' . $translateKey);
		if(is_array($translate)) {
			return $translate;
		}
		return null;
	}
	
	private static function normalizeTranslate($translate, Exception $exception) {
		$translate['exception'] = $exception;
		if(empty($translate['name'])) {
			$translate['name'] = self::getExceptionName($exception);
		}
		if(YII_ENV_PROD && !empty($translate) && empty($translate['message'])) {
			/** @var array $forProduction */
			$forProduction = I18Next::t('error', 'main.error_for_production');
			$translate = ArrayHelper::merge($translate, $forProduction);
		}
		if(empty($translate['message'])) {
			$translate['message'] = $exception->getMessage();
		}
		return $translate;
	}
	
	private static function getTranslate(Exception $exception) {
		$translate = self::getTranslateByClassName($exception);
		if(!$translate) {
			$translate = self::getTranslateByStatusCode($exception);
		}
		$message = $exception->getMessage();
		if($message) {
			$translate['message'] = $message;
		}
		return $translate;
	}
	
	private static function normalizeTranslateKey($translateKey) {
		$translateKey = Inflector::variablize($translateKey);
		$translateKey = Inflector::underscore($translateKey);
		return $translateKey;
	}
	
}
