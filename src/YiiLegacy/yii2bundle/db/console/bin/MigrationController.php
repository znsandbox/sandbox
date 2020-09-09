<?php

namespace yii2bundle\db\console\bin;

use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii2bundle\db\domain\helpers\DbHelper;
use yii2bundle\db\domain\helpers\Fixtures;
use yii2rails\extension\console\helpers\input\Question;
use yii2rails\extension\console\helpers\input\Select;
use yii2rails\extension\console\helpers\Output;
use yii2rails\extension\console\base\Controller;
use yii2rails\domain\data\EntityCollection;
use yii2tool\vendor\domain\entities\TestEntity;
use yii2rails\extension\console\helpers\input\Enter;
use yii2bundle\db\domain\helpers\MigrationHelper;

class MigrationController extends \yii\base\Component
{
	
	public function init() {
		parent::init();
		Output::line();
	}

    /**
     * Generate migration with columns and foreign keys
     */
    public function actionGenerate()
    {
        /** @var Fixtures $fixtures */
        $fixtures = Yii::createObject(Fixtures::class);
        $allTables = DbHelper::tableNameList();
        if(!empty($allTables)) {
            $answer = Select::display('Select tables', $allTables, 1);
            foreach ($answer as $table) {
                Output::line('Generate migration for "' . $table . '"');
                $className = MigrationHelper::generateByTableName($table);
            }
            Output::line('Migrations generated!');
        } else {
            Output::block("not tables!");
        }
    }

}
