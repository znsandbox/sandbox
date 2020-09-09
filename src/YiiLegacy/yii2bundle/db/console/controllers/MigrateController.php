<?php

namespace yii2bundle\db\console\controllers;

class MigrateController extends \dee\console\MigrateController {
	
	public $migrationPath = '@console/migrations';
	public $generatorTemplateFiles = [
		'create_table' => '@yii2bundle/db/domain/yii/views/createTableMigration.php',
		'drop_table' => '@yii/views/dropTableMigration.php',
		'add_column' => '@yii/views/addColumnMigration.php',
		'drop_column' => '@yii/views/dropColumnMigration.php',
		'create_junction' => '@yii/views/createTableMigration.php',
	];
	
}
