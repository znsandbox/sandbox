<?php

namespace yii2rails\extension\store\drivers;

use yii2rails\extension\code\helpers\generator\FileGeneratorHelper;
use yii2rails\extension\common\helpers\StringHelper;
use yii2rails\extension\store\interfaces\DriverInterface;
use yii\helpers\VarDumper;
use yii2rails\extension\yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

class Php implements DriverInterface
{

	public function decode($content) {
		$code = '$data = ' . $content . ';';
		eval($code);
		/** @var mixed $data */
		return $data;
	}

	public function encode($data) {
		$content = VarDumper::export($data);
		$content = StringHelper::setTab($content, 4);
		return $content;
	}

	public function save($fileName, $data) {
		$content = $this->encode($data);
		$code = PHP_EOL . PHP_EOL . 'return ' . $content . ';';
		FileHelper::save($fileName, $code);
		$data['fileName'] = $fileName;
		$data['code'] = $code;
		FileGeneratorHelper::generate($data);
	}
	
	public function load($fileName, $key = null) {
		if(!FileHelper::has($fileName)) {
			return null;
		}
		$data = include($fileName);
		if($key !== null) {
			return ArrayHelper::getValue($data, $key);
		}
		return $data;
	}

}