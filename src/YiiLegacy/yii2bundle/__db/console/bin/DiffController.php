<?php

namespace yii2bundle\db\console\bin;

use Yii;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii2bundle\db\domain\entities\TableEntity;
use yii2bundle\db\domain\helpers\DbHelper;
use yii2bundle\db\domain\helpers\DiffHelper;
use yii2bundle\db\domain\helpers\TableHelper;
use yii2rails\app\domain\helpers\EnvService;
use yii2rails\extension\console\helpers\Error;
use yii2rails\extension\console\helpers\input\Question;
use yii2rails\extension\console\helpers\input\Select;
use yii2rails\extension\console\helpers\Output;
use yii2rails\extension\console\base\Controller;
use yii2rails\domain\data\EntityCollection;
use yii2tool\vendor\domain\entities\TestEntity;
use yii2rails\extension\console\helpers\input\Enter;
use yii2bundle\db\domain\helpers\MigrationHelper;

class DiffController extends \yii\base\Component
{
	
	public function init() {
		parent::init();
		Output::line();
	}

    public function actionCompare()
    {
        $db = EnvService::getServer('db');
        $connections = array_keys($db);
        $connectionNames = Select::display('Select connections', $connections);
        $connectionNames = array_values($connectionNames);

        if(count($connectionNames) != 2) {
            Error::fatal('Select 2 connections!');
        }

        DiffHelper::$skipColumnValues = [
            'default_value' => null,
            'precision' => null,
            'comment' => null,
            'php_type' => null,
            'size' => null,
            'type' => [
                [
                    'bigint',
                    'integer',
                ],
                [
                    'smallint',
                    'integer',
                ],
                [
                    'text',
                    'string',
                ],
                [
                    'json',
                    'text',
                ],
            ],
        ];
        $maps = DiffHelper::getMaps($connectionNames);

        $tableNames = Select::display('Select tables', array_keys($maps));

        $allTables = DiffHelper::diff($tableNames, $connectionNames);

        d($allTables);
    }

}
