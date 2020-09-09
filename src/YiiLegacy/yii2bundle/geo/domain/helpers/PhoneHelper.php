<?php

namespace yii2bundle\geo\domain\helpers;

use yii2rails\extension\common\helpers\StringHelper;
use yii2bundle\geo\domain\entities\PhoneInfoEntity;

class PhoneHelper {
	
	public static function matchPhone(string $phone, string $rule) {
		$phone = self::clean($phone);
		$exp = '/^' . $rule . '$/';
		$isMatch = preg_match($exp, $phone, $matches);
		if($isMatch) {
			$phoneInfoEntity = new PhoneInfoEntity;
			$phoneInfoEntity->id = $phone;
			$phoneInfoEntity->country = $matches[1];
			$phoneInfoEntity->provider = $matches[2];
			$phoneInfoEntity->client = $matches[3];
			return $phoneInfoEntity;
		}
		return false;
	}
	
	public static function clean($phone) {
		$phone = StringHelper::removeAllSpace($phone);
		$phone = preg_replace('#[^\d]+#', EMP, $phone);
		return $phone;
	}
	
	public static function formatByMask($phone, $mask) {
		$phone = self::clean($phone);
		$maskArray = str_split($mask, 1);
		$pos = 0;
		$result = '';
		foreach($maskArray as $char) {
			if($char == '9') {
				$char = $phone{$pos};
				$pos++;
			}
			$result .= $char;
		}
		return $result;
	}
	
}