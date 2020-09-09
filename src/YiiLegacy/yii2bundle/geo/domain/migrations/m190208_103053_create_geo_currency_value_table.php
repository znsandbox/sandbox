<?php

use yii2bundle\db\domain\db\MigrationCreateTable as Migration;

/**
 * Class m190208_103053_create_geo_currency_value_table
 * 
 * @package 
 */
class m190208_103053_create_geo_currency_value_table extends Migration {

	public $table = '{{%geo_currency_value}}';
    public $tableComment = 'Курс валют';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'code' => $this->string(4)->notNull(),
			'value' => $this->double()->notNull(),
			'publicated_at' => $this->timestamp()->notNull(),
		];
	}

	public function afterCreate()
	{
		$this->myCreateIndexUnique(['code', 'publicated_at']);
	}

}