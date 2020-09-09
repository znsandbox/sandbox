<?php

namespace yii2rails\domain\helpers;

use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\base\UnknownPropertyException;
use yii\web\NotFoundHttpException;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\interfaces\services\ReadOneInterface;
use yii2rails\domain\services\base\BaseService;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class ServiceHelper {
	
	public static function isExists(string $domain, string $service) {
		if(!DomainHelper::has($domain)) {
			return false;
		}
		if(empty($service)) {
			throw new InvalidArgumentException('Service name can not be empty!');
		}
		try {
			\App::$domain->{$domain}->{$service};
			return true;
		} catch(UnknownPropertyException $e) {
		} catch(InvalidConfigException $e) {
        }
		return false;
	}
	
	public static function one(string $domain, string $service) {
		if(!self::isExists($domain, $service)) {
			throw new InvalidArgumentException('Service "' . $domain . '->' . $service . '" not defined!');
		}
		return \App::$domain->{$domain}->{$service};
	}
	
	public static function has($serviceName) {
		try {
		    list($domainId, $serviceId) = explode(DOT, $serviceName);
		    if(!\App::$domain->has($domainId)) {
                return false;
            }
            if(!\App::$domain->{$domainId}->has($serviceId)) {
                return false;
            }
            return true;
			//$serviceInstance = ArrayHelper::has(\App::$domain, $serviceName);
			return is_object($serviceInstance);
		} catch(UnknownPropertyException $e) {
			return false;
		}
	}
	
	/**
	 * @param      $service
	 * @param mixed $default
	 *
	 * @return BaseService
	 * @throws InvalidConfigException
	 */
	public static function get($service, $default = null) {
		if($service instanceof BaseService) {
			return $service;
		}
		$serviceInstance = ArrayHelper::getValue(\App::$domain, $service, $default);
		if(!is_object($serviceInstance)) {
			throw new InvalidConfigException("Service \"$service\" not found");
		}
		return $serviceInstance;
	}
	
	/**
	 * @param $serviceName
	 * @param $id
	 *
	 * @return BaseEntity
	 * @throws InvalidConfigException
	 */
	public static function oneById($serviceName, $id)
	{
		if(!self::has($serviceName)) {
			return null;
		}
		/** @var ReadOneInterface $serviceInstance */
		$serviceInstance = self::get($serviceName);
		try {
			$result = $serviceInstance->oneById($id);
		} catch (NotFoundHttpException $e) {
			$result = null;
		}
		return $result;
	}
}