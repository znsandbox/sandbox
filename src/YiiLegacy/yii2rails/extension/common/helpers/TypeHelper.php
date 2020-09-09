<?php

namespace yii2rails\extension\common\helpers;

use DateTime;
use Yii;
use yii\helpers\ArrayHelper;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\data\EntityCollection;
use yii2rails\domain\helpers\types\BaseType;
use yii2rails\domain\interfaces\ValueObjectInterface;
use yii2rails\domain\values\TimeValue;
use yii2rails\extension\web\enums\HttpHeaderEnum;

class TypeHelper {
	
	const INTEGER = 'integer';
	const FLOAT = 'float';
	const STRING = 'string';
	const BOOLEAN = 'boolean';
	const NULL = 'null';
	
	private static $_instanceTypes = [];
	
	private static function decodeValueObject($value) {
		if($value instanceof TimeValue) {
            $resultValue = $value->getInFormat(DateTime::ISO8601);
		} elseif($value instanceof ValueObjectInterface) {
			$resultValue = $value->get();
		} else {
			$resultValue = $value;
		}
		return $resultValue;
	}
	
	private static function entityToArray($entity) {
		if(method_exists($entity, 'toArrayRaw')) {
            /** @var BaseEntity $entity */
		    $item = $entity->toArrayRaw([],[],false);
		} elseif(method_exists($entity, 'toArray')) {
			$item = $entity->toArray();
		} elseif(is_object($entity)) {
			$item = ArrayHelper::toArray($entity);
		} else {
            $item = $entity;
        }
        if(!is_array($item)) {
            return $item;
        }
		foreach($item as $fieldName => $value) {
		    $isIndexedArray = is_array($value) && ArrayHelper::isIndexed($value);
		    $isCollection = $isIndexedArray || $value instanceof EntityCollection;
		    if($isCollection) {
                $item[ $fieldName ] = self::serializeModels($value);
            } else {
                if($value instanceof ValueObjectInterface) {
                    $item[ $fieldName ] = self::decodeValueObject($value);
                }
                $pureValue = ArrayHelper::getValue($entity, $fieldName);
                if($pureValue instanceof BaseEntity) {
                    $item[ $fieldName ] = self::entityToArray($pureValue);
                }
            }
		}
		return $item;
	}
	
	private static function normalizeItemTypes($item, $formatMap) {
		foreach($formatMap as $fieldName => $format) {
			if(is_array($format)) {
				if(isset($item[ $fieldName ])) {
					if(ArrayHelper::isIndexed($item[ $fieldName ])) {
						foreach($item[ $fieldName ] as $kk => $vv) {
							$item[ $fieldName ][ $kk ] = self::serialize($vv, $format);
						}
					} else {
						$item[ $fieldName ] = self::serialize($item[ $fieldName ], $format);
					}
				}
				continue;
			}
			if(!array_key_exists($fieldName, $item)) {
				continue;
			}
			if($format == 'hide') {
				unset($item[ $fieldName ]);
			} elseif($format == 'hideIfNull' && empty($item[ $fieldName ])) {
				unset($item[ $fieldName ]);
			} else {
				$item[ $fieldName ] = self::encode($item[ $fieldName ], $format);
			}
		}
		return $item;
	}

    public static function serializeModels($models, $formatMap = null) {
        if($models instanceof EntityCollection) {
            $models = $models->all();
        }
        foreach($models as &$item) {
            $item = TypeHelper::serialize($item, $formatMap);
        }
        return $models;
    }

	public static function serialize($entity, $formatMap) {
		$item = self::entityToArray($entity);
		if(!empty($formatMap)) {
			$item = self::normalizeItemTypes($item, $formatMap);
		}
		return $item;
	}
	
	public static function encode($value, $typeStr) {
		list($type, $param) = self::parseType($typeStr);
		/** @var BaseType $instanceType */
		$instanceType = self::getInstanceType($type);
		if($instanceType) {
			$instanceType->validate($value, $param);
			$value = $instanceType->normalizeValue($value, $param);
		} elseif(function_exists($type)) {
			if(isset($param)) {
				$value = $type($value, $param);
			} else {
				$value = $type($value);
			}
		}
		return $value;
	}
	
	private static function parseType($typeStr) {
		$arr = explode(':', $typeStr);
		$param = null;
		if(count($arr) > 1) {
			list($type, $param) = $arr;
		} else {
			list($type) = $arr;
		}
		return [$type, $param];
	}
	
	public static function getInstanceType($class) {
		$class = 'yii2rails\domain\helpers\types\\' . ucfirst($class) . 'Type';
		if(!class_exists($class)) {
			return null;
		}
		if(!array_key_exists($class, self::$_instanceTypes)) {
			self::$_instanceTypes[$class] = new $class;
		}
		return self::$_instanceTypes[$class];
	}
	
}
