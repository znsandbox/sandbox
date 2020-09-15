<?php

namespace yii2bundle\db\domain\filters\init;

use Yii;
use yii\base\BaseObject;
use yii2rails\extension\console\helpers\Output;
use yii2bundle\db\domain\helpers\Fixtures;

class ImportFixture extends BaseObject
{
	
	public $tableList;
	
	public function run() {
		$fixtures = Yii::createObject(Fixtures::class);
		$tables = $fixtures->import($this->tableList);
		Output::items($tables, 'Imported tables');
	}
	
}
