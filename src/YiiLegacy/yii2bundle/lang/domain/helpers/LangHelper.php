<?php

namespace yii2bundle\lang\domain\helpers;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use yii2rails\domain\helpers\DomainHelper;
use yii2rails\extension\common\helpers\ModuleHelper;

class LangHelper {
	
	const PREFIX_MODULE = 'module:';
	const PREFIX_DOMAIN = 'domain:';
	
	public static function normalizeTranslation($config) {
		$config['class'] = 'yii2bundle\lang\domain\i18n\PhpMessageSource';
		return $config;
	}
	
	public static function getId($bundle, $category = null) {
		$bundleArray = explode(':', $bundle);
		$hasType = count($bundleArray) > 1;
		if(!$hasType) {
			$typePrefix = self::getBundleTypePrefix($bundleArray[0]);
			if($typePrefix) {
				$bundle = $typePrefix . $bundle;
			}
		}
		if(!empty($category)) {
			$bundle .= SL . $category;
		}
		return $bundle;
	}
	
	public static function extractList($list) {
		foreach($list as $name => $message) {
			$list[$name] = self::extract($message);
		}
		return $list;
	}
	
	public static function extract($message) {
		if(empty($message)) {
			return '';
		}
		if(is_array($message)) {
            $messages = explode('/', $message[0]);
            if(count($messages) > 1) {
                // todo: workaround for support old rails style
                $message[0] = $messages[0];
                $message[1] = $messages[1] . '.' . $message[1];
            }
            $message = call_user_func_array([I18Next::class, 't'], $message);
			//$message = call_user_func_array('Yii::t', $message);
		}
		return $message;
	}
	
	private static function getBundleTypePrefix($bundleName) {
		if(DomainHelper::has($bundleName)) {
			return self::PREFIX_DOMAIN;
		}
		if(ModuleHelper::has($bundleName)) {
			return self::PREFIX_MODULE;
		}
		return null;
	}
	
}
