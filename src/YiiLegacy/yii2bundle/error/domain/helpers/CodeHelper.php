<?php

namespace yii2bundle\error\domain\helpers;

use Throwable;
use Yii;
use yii\helpers\Inflector;
use yii2rails\extension\yii\helpers\FileHelper;

class CodeHelper
{
	
	public static function codeLineFromException(Throwable $exception) {
		$code = FileHelper::load($exception->getFile());
		$codeLines = preg_split('#\n#', $code);
		$codeLine = $codeLines[$exception->getLine()-1];
		return $codeLine;
	}
	
	private function makePermission() {
		if(!YII_ENV_DEV) {
			return false;
		}
		$isMatch = preg_match('#Undefined\sclass\sconstant\s\'([^\']+)\'#', $exception->getMessage(), $matches);
		if($isMatch) {
			//$codeLine =
			$isMatch2 = preg_match('#PermissionEnum::([A-Z_]+)#', $codeLine, $matches2);
			if($isMatch2) {
				$permissionName = strtolower($matches2[1]);
				$permissionName = Inflector::camelize($permissionName);
				$permissionName = 'o' . $permissionName;
				$item = \App::$domain->rbac->item->createPermission($permissionName);
				$item->description = '### Это полномочие сгенерированно автоматически, по причине его отсутсвия!';
				\App::$domain->rbac->item->addItem($item);
				return $permissionName;
			}
		}
		return false;
	}
	
}
