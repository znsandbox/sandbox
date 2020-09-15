<?php

namespace yii2bundle\db\console\bin;

use yii2bundle\db\domain\enums\DbDriverEnum;
use yii2rails\app\domain\helpers\EnvService;
use yii2rails\extension\console\helpers\Error;
use yii2rails\extension\console\helpers\input\Enter;
use yii2rails\extension\console\helpers\input\Question;
use yii2rails\extension\console\helpers\input\Select;
use yii2rails\extension\console\helpers\Output;

class SchemaController extends \yii\base\Component
{
	
	public function init() {
		parent::init();
		Output::line();
	}

    public function actionCreate()
    {
        $db = EnvService::getServer('db');
        if($db['main']['driver'] != DbDriverEnum::PGSQL) {
            Error::fatal('DB driver need Postgres!');
        }
        if(empty($db['main']['map'])) {
            Error::fatal('Empty map!');
        }
        $schemas = [];
        foreach($db['main']['map'] as $value) {
            $arr = explode(DOT, $value);
            if(count($arr) > 1) {
                $schemas[] = $arr[0];
            }
        }
        $schemas[] = $db['main']['defaultSchema'];
        $schemas = array_unique($schemas);
        $schemas = array_values($schemas);
        foreach ($schemas as $schema) {
            $sql = 'CREATE SCHEMA IF NOT EXISTS "' . $schema . '"';
            \Yii::$app->db->createCommand($sql)->execute();
        }
        Output::title('All schemas created');
        Output::arr($schemas);
    }

    public function actionRemove()
    {
        Question::confirm('Remove all schemas?', 1);
        $db = EnvService::getServer('db');
        if($db['main']['driver'] != DbDriverEnum::PGSQL) {
            Error::fatal('DB driver need Postgres!');
        }
        if(empty($db['main']['map'])) {
            Error::fatal('Empty map!');
        }
        $schemas = [];
        foreach($db['main']['map'] as $value) {
            $arr = explode(DOT, $value);
            if(count($arr) > 1) {
                $schemas[] = $arr[0];
            }
        }
        $schemas[] = $db['main']['defaultSchema'];
        $schemas = array_unique($schemas);
        $schemas = array_values($schemas);
        foreach ($schemas as $schema) {
            $sql = 'DROP SCHEMA "' . $schema . '" CASCADE';
            try {
                \Yii::$app->db->createCommand($sql)->execute();
                Output::line('DROP SCHEMA "' . $schema . '"');
            } catch (\Exception $e) {
                Output::line('DROP SCHEMA "' . $schema . '" Fail');
            }
        }
        Output::title('All schemas deleted');
        Output::arr($schemas);
    }

}
