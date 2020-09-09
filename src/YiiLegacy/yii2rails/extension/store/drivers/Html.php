<?php

namespace yii2rails\extension\store\drivers;

use yii2rails\extension\code\helpers\generator\FileGeneratorHelper;
use yii2rails\extension\common\helpers\StringHelper;
use yii2rails\extension\store\interfaces\DriverInterface;
use yii\helpers\VarDumper;
use yii2rails\extension\yii\helpers\FileHelper;

class Html implements DriverInterface
{

	public function decode($code) {
		return $code;
	}

	public function encode($code) {
		return $code;
	}

	public function save($fileName, $data) {
		$content = $this->encode($data);
		//$code = PHP_EOL . PHP_EOL . 'return ' . $content . ';';
		FileHelper::save($fileName, $content);
		//$data['fileName'] = $fileName;
		//$data['code'] = $code;
		//FileGeneratorHelper::generate($data);
	}
	
	public function load($fileName, $key = null) {
		if(!FileHelper::has($fileName)) {
			return null;
		}
		$data = FileHelper::load($fileName);
		return $data;
	}

}