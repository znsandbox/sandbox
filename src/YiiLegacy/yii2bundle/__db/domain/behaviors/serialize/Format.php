<?php

namespace yii2bundle\db\domain\behaviors\serialize;

class Format
{
 
	public static function encode($array) {
		if(empty($array)) {
			return serialize([]);
		}
		return serialize($array);
	}
	
	public static function decode($data) {
		if(is_array($data)) {
			return $data;
		}
		if(substr($data, 0, 2) == '{"') {
            $result = json_decode($data, JSON_OBJECT_AS_ARRAY);
        } else {
            $result = unserialize($data);
        }
		if(empty($result)) {
			return [];
		}
		return $result;
	}
	
}
