<?php

namespace yii2bundle\db\domain\helpers;

use yii\helpers\ArrayHelper;
use yii2rails\app\domain\helpers\EnvService;
use yii2rails\extension\common\helpers\Helper;
use yii2rails\extension\common\helpers\UrlHelper;
use yii2bundle\db\domain\enums\DbDriverEnum;
use Yii;
use yii\db\Exception;
use yii\db\Connection;
use yii2bundle\db\domain\helpers\DbHelper;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use yii2rails\domain\helpers\ErrorCollection;

class TableHelper
{

    private static $map = null;

    public static function getLocalName(string $tableName, array $map = null) {
        if(isset($map)) {
            $map = array_flip($map);
            $globalName = ArrayHelper::getValue($map, $tableName);
        } else {
            self::loadMap();
            $map = array_flip(self::$map);
            $globalName = ArrayHelper::getValue($map, $tableName);
        }
        if($globalName) {
            $tableName = $globalName;
        }
        return $tableName;
    }

	public static function getGlobalName(string $tableName, array $map = null) {
		if(isset($map)) {
            $globalName = ArrayHelper::getValue($map, $tableName);
        } else {
            self::loadMap();
            $globalName = ArrayHelper::getValue(self::$map, $tableName);
        }
        if($globalName) {
            $tableName = $globalName;
        }
		return $tableName;
	}

	private static function loadMap() {
	    if(self::$map === null) {
            $config = EnvService::getConnection('main');
            if($config['driver'] == 'pgsql') {
                self::$map = ArrayHelper::getValue($config, 'map', []);
            } else {
                self::$map = [];
            }
        }
    }
}
