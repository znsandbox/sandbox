<?php

namespace yii2bundle\db\console\bin;

use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii2bundle\db\domain\helpers\DbHelper;
use yii2rails\extension\console\handlers\RenderHahdler;
use yii2rails\extension\console\helpers\ArgHelper;
use yii2rails\extension\console\helpers\input\Question;
use yii2rails\extension\console\helpers\Output;
use yii2rails\extension\console\base\Controller;
use yii2rails\domain\data\EntityCollection;
use yii2tool\vendor\domain\entities\TestEntity;
use yii2bundle\db\domain\helpers\Fixtures;
use yii2rails\extension\console\helpers\input\Select;
use yii2rails\extension\console\helpers\input\Enter;

class FixtureController extends \yii\base\Component
{
	
	public function init() {
		parent::init();
		Output::line();
	}

    /**
     * Export or import fixtures
     */
    public function actionIndex($option = null, $answer = null)
    {
        $args = ArgHelper::all();
        if(array_key_exists('-i', $args)) {
            $option = 'i';
        }
        if(array_key_exists('-e', $args)) {
            $option = 'e';
        }
        if(array_key_exists('-a', $args)) {
            $answer = 'a';
        }
        /** @var Fixtures $fixtures */
        $fixtures = Yii::createObject(Fixtures::class);
        $fixtures->outputHandler = new RenderHahdler;
        if(empty($option)) {
            $option = Question::displayWithQuit('Select operation', ['Export', 'Import'], $option);
        }
        if($option == 'e') {
            $allTables = DbHelper::tableNameList();
            if(!empty($allTables)) {
                $answer = Select::display('Select tables for export', $allTables, 1, 0, $answer);
                $tables = $fixtures->export($answer);
                Output::items($tables, 'Exported tables');
            } else {
                Output::block("not tables for export!");
            }
        } elseif($option == 'i') {
            $allTables = $fixtures->fixtureNameList();
            if(!empty($allTables)) {
                $answer = Select::display('Select tables for import', $allTables, 1, 0, $answer);
                $tables = $fixtures->import($answer);
                Output::items($tables, 'Imported tables');
            } else {
                Output::block("not tables for import!");
            }
        }
    }

    /**
     * Export or import one table
     */
    public function actionOne($option = null)
    {
        /** @var Fixtures $fixtures */
        $fixtures = Yii::createObject(Fixtures::class);
        $fixtures->outputHandler = new OutputHandler;
        $option = Question::displayWithQuit('Select operation', ['Export', 'Import'], $option);
        if($option == 'e') {
            $table = Enter::display('Enter table name for export');
            $tables = $fixtures->export([$table]);
            Output::items($tables, 'Exported tables');
        } elseif($option == 'i') {
            $table = Enter::display('Enter table name for import');
            $tables = $fixtures->import([$table]);
            Output::items($tables, 'Imported tables');
        }
    }

}
