<?php

use yii2bundle\db\domain\db\MigrationCreateTable as Migration;

/**
 * Class m190109_082800_create_language_table
 * 
 * @package 
 */
class m190101_082800_create_language_table extends Migration {

	public $table = 'language';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'code' => $this->string(4)->notNull(),
			'title' => $this->string(255)->notNull(),
			'name' => $this->string(64)->notNull(),
			'locale' => $this->string(10)->notNull(),
			'is_main' => $this->boolean()->notNull(),
			'is_enabled' => $this->boolean()->notNull(),
		];
	}

	public function afterCreate()
	{
		$this->myAddPrimaryKey('code');
		$this->myCreateIndexUnique('title');
		$this->myCreateIndexUnique('name');
		$this->myCreateIndexUnique('locale');
	}

}