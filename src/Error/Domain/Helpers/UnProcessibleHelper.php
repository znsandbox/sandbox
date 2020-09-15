<?php

namespace ZnSandbox\Sandbox\Error\Domain\Helpers;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii2rails\domain\helpers\ErrorCollection;

class UnProcessibleHelper
{
	
	public static function getFirstErrors($errors) {
		$errors = self::assoc2indexed($errors);
		$result = [];
		foreach($errors as $error) {
			$result[$error['field']] = $error['message'];
		}
		return $result;
	}
	
	public static function assoc2indexed($errors) {
		if(ArrayHelper::isIndexed($errors)) {
			return $errors;
		}
		if($errors instanceof Model) {
			$errors = $errors->getErrors();
		}
		if($errors instanceof ErrorCollection) {
			return $errors->all();
		}
		return self::normalizeArray($errors);
	}
	
	public static function indexed2assoc($errors) {
		if(!ArrayHelper::isIndexed($errors)) {
			return $errors;
		}
		if($errors instanceof Model) {
			$errors = $errors->getErrors();
		}
		if($errors instanceof ErrorCollection) {
			return $errors->all();
		}
		return self::normalizeArray1($errors);
	}
	
	private static function normalizeArray1(array $errors) {
		$result = [];
		if(!empty($errors)) {
			foreach($errors as $error) {
				$field = $error['field'];
				$message = $error['message'];
				$result[$field][] = $message;
			}
		}
		return $result;
	}
	
	private static function normalizeArray(array $errors) {
		$result = [];
		if(!empty($errors)) {
			foreach($errors as $field => $error) {
				foreach ($error as $message) {
					$result[] = [
						'field' => $field,
						'message' => $message,
					];
				}
			}
		}
		return $result;
	}
	
}
