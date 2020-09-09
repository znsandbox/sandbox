<?php

namespace yii2rails\extension\code\helpers\generator;

use Yii;
use yii2rails\extension\yii\helpers\ArrayHelper;
use yii2rails\extension\yii\helpers\FileHelper;

class FileGeneratorHelper {
	
	public static function generate($data) {
		$code = self::generateCode($data);
		if(!empty($data['dirAlias']) && !empty($data['baseName'])) {
			$fileName = Yii::getAlias($data['dirAlias'].'/'.$data['baseName'].'.php');
		} elseif(!empty($data['fileName'])) {
			$fileName = $data['fileName'];
		}
		FileHelper::save($fileName, $code);
	}
	
	private static function generateCode($data) {
		$data['code'] = ArrayHelper::getValue($data, 'code');
		$data['code'] = trim($data['code'], PHP_EOL);
		$data['code'] = PHP_EOL . $data['code'];
		$code = self::getClassCodeTemplate();
		$code = str_replace('{code}', $data['code'], $code);
		return $code;
	}

	private static function getClassCodeTemplate() {
		$code = <<<'CODE'
<?php
{code}
CODE;
		return $code;
	}
	
}
