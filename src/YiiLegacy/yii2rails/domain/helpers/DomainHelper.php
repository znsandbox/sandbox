<?php

namespace yii2rails\domain\helpers;

use Yii;
use yii\base\InvalidArgumentException;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\Domain;
use yii2rails\extension\common\helpers\ClassHelper;
use yii2rails\extension\common\helpers\Helper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class DomainHelper {
	
	public static function createDomain($id, $class) {
		$definition = ConfigHelper::normalizeItemConfig($id, $class);
		/** @var \yii2bundle\rbac\domain\Domain $domain */
		$domain = Yii::createObject($definition);
		return $domain;
	}

    public static function forgeDomains2($config) {
        foreach($config as $id => $definition) {
            if(!\App::$domain->has($id)) {
                self::defineDomain2($id, $definition);
            }
        }
    }

	public static function forgeDomains($config) {
		foreach($config as $id => $definition) {
			if(!\App::$domain->has($id)) {
				self::defineDomain($id, $definition);
			}
		}
	}
	
	public static function defineDomains($config) {
		foreach($config as $id => $definition) {
			self::defineDomain($id, $definition);
		}
	}

    public static function defineDomain2($id, $definition) {
	    if(is_array($definition)) {
            $class = $definition['class'];
            unset($definition['class']);
            $domainDefinition = DomainHelper::getClassConfig($id, $class, $definition);
        } else {
            $domainDefinition = DomainHelper::getClassConfig($id, $definition);
        }
        \App::$domain->set($id, $domainDefinition);
    }

	public static function defineDomain($id, $class) {
		$domainDefinition = DomainHelper::getClassConfig($id, $class);
		self::define($id, $domainDefinition);
	}
	
	public static function isDomain($config) {
		if(empty($config['class'])) {
			return false;
		}
		if($config['class'] == Domain::class || is_subclass_of($config['class'], Domain::class)) {
			return true;
		}
		return false;
	}
	
	/**
	 * @param $domainId
	 * @param $definition
	 *
	 * @throws \yii\base\InvalidConfigException
	 */
	private static function define($domainId, $definition) {
		if(!\App::$domain->has($domainId)) {
            $definition = ConfigHelper::normalizeItemConfig($domainId, $definition);
			\App::$domain->set($domainId, $definition);
		}
	}
	
	/**
	 * @param string     $domainId
	 * @param            $className
	 * @param array|null $classDefinition
	 *
	 * @return array|mixed|null
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function getClassConfig(string $domainId, $className, array $classDefinition = null) {
		$definition = self::getConfigFromDomainClass($className);
		$definition = ConfigHelper::normalizeItemConfig($domainId, $definition);
		if(!empty($classDefinition)) {
			$classDefinition =  ConfigHelper::normalizeItemConfig($domainId, $classDefinition);
			$definition = ArrayHelper::merge($definition, $classDefinition);
		}
		$definition['class'] = $className;
		return $definition;
	}
	
	/**
	 * @param $className
	 *
	 * @return array
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function getConfigFromDomainClass($className) {
		$definition = ClassHelper::normalizeComponentConfig($className);
		/** @var Domain $domain */
		$domain = Yii::createObject($definition);
		$config = $domain->config();
		return $config;
	}
	
	public static function isEntity($data) {
		return is_object($data) && $data instanceof BaseEntity;
	}
	
	public static function isCollection($data) {
		return is_array($data);
	}
	
	/**
	 * @param $name
	 *
	 * @return bool
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function has($name) {
		if(empty($name)) {
			throw new InvalidArgumentException('Domain name can not be empty!');
		}
		if(!\App::$domain->has($name)) {
			return false;
		}
		$domain = \App::$domain->get($name);
		if(!$domain instanceof Domain) {
			return false;
		}
		return true;
	}
	
	public static function messagesAlias($bundleName) {
		if(!\App::$domain->has($bundleName)) {
			return false;
		}
		$domain = ArrayHelper::getValue(\App::$domain, $bundleName);
		if(empty($domain) || empty($domain->path)) {
			return null;
		}
		return Helper::getBundlePath($domain->path . SL . 'messages');
	}
	
}