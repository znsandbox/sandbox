<?php

namespace yii2rails\extension\code\helpers;

use yii2rails\extension\code\entities\CodeEntity;
use yii2rails\extension\code\render\CodeRender;
use yii2rails\extension\yii\helpers\FileHelper;
use yii2rails\extension\store\Store;

class CodeHelper
{
	
	public static function generatePhpData($alias, $data) {
		$codeEntity = new CodeEntity();
		$codeEntity->fileName = $alias;
		$codeEntity->code = self::encodeDataForPhp($data);
		self::save($codeEntity);
	}
	
	public static function save(CodeEntity $codeEntity) {
		$pathName = FileHelper::getPath('@' . $codeEntity->fileName);
		$fileName = $pathName . DOT . $codeEntity->fileExtension;
		$code = CodeHelper::render($codeEntity);
		FileHelper::save($fileName, $code);
	}
	
	private static function render(CodeEntity $codeEntity) {
		$render = new CodeRender();
		$render->entity = $codeEntity;
		return $render->run();
	}
	
	private static function encodeDataForPhp($data) {
		$store = new Store('php');
		$content = $store->encode($data);
		$code = 'return ' . $content . ';';
		return $code;
	}
}
