<?php

namespace yii2bundle\db\console\controllers;

use yii2rails\extension\console\helpers\input\Enter;
use yii2rails\extension\console\helpers\Output;
use yii2rails\extension\console\base\Controller;
use yii2bundle\db\domain\helpers\MigrationHelper;

/**
 * Migration tools
 */
class MigrationController extends Controller
{
	
	/**
	 * Generate migration with columns and foreign keys
	 */
	public function actionGenerate()
	{
		$tableName = Enter::display('Enter table name');
		$className = MigrationHelper::generateByTableName($tableName);
		Output::block($className, 'Migration created!');
	}
	
}
